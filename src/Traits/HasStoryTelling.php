<?php
/**
 * Created by PhpStorm.
 * Filename: HasStoryTelling.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 30/12/21
 * Time: 17:25
 * MIT License
 *
 * Copyright (c) [2021] [laravel-bricks-bootstrap5]
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace TtenSrl\Telling\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use TtenSrl\Telling\Models\Version;

/**
 * Class Version
 * @package TtenSrl\Telling
 */
trait HasStoryTelling
{

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function getVersionClass()
    {
        if( property_exists( self::class, 'versionClass') ) {
            return $this->versionClass;
        }

        return config('bricks-telling.version_model', Version::class);
    }

    /**
     * Private variable to detect if this is an update
     * or an insert
     * @var bool
     */
    private $updating;

    /**
     * Contains all dirty data that is valid for versioning
     *
     * @var array
     */
    private $versionableDirtyData;

    /**
     * Optional reason, why this version was created
     * @var string
     */
    private $reason;

    /**
     * Flag that determines if the model allows versioning at all
     * @var bool
     */
    protected $versioningEnabled = true;

    /**
     * @return $this
     */
    public function enableVersioning()
    {
        $this->versioningEnabled = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableVersioning()
    {
        $this->versioningEnabled = false;
        return $this;
    }

    /**
     * Attribute mutator for "reason"
     * Prevent "reason" to become a database attribute of model
     *
     * @param string $value
     */
    public function setReasonAttribute($value)
    {
        $this->reason = $value;
    }

    /**
     * Initialize model events
     */
    public static function bootHasStoryTelling()
    {
        static::saving(function ($model) {
            $model->versionablePreSave();
        });

        static::saved(function ($model) {
            $model->versionablePostSave();
        });

    }

    /**
     * Return all versions of the model
     * @return MorphMany
     */
    public function versions()
    {
        return $this->morphMany( $this->getVersionClass(), 'versionable');
    }

    /**
     * Returns the latest version available
     * @return Version
     */
    public function currentVersion()
    {
        return $this->getLatestVersions()->first();
    }

    /**
     * Returns the previous version
     * @return Version
     */
    public function previousVersion()
    {
        return $this->getLatestVersions()->limit(1)->offset(1)->first();
    }

    /**
     * Get a model based on the version id
     *
     * @param $version_id
     *
     * @return $this|null
     */
    public function getVersionModel($version_id)
    {
        $version = $this->versions()->where("version_id", "=", $version_id)->first();
        if (!is_null($version)) {
            return $version->getModel();
        }
        return null;
    }

    /**
     * Pre save hook to determine if versioning is enabled and if we're updating
     * the model
     * @return void
     */
    protected function versionablePreSave()
    {
        if ($this->versioningEnabled === true) {
            $this->versionableDirtyData = $this->getDirty();
            $this->updating             = $this->exists;
        }
    }

    /**
     * Save a new version.
     * @return void
     */
    protected function versionablePostSave()
    {
        /**
         * We'll save new versions on updating and first creation
         */
        if (
            ( $this->versioningEnabled === true && $this->updating && $this->isValidForVersioning() ) ||
            ( $this->versioningEnabled === true && !$this->updating && !is_null($this->versionableDirtyData) && count($this->versionableDirtyData))
        ) {
            // Save a new version
            $class                     = $this->getVersionClass();
            $version                   = new $class();
            $version->versionable_id   = $this->getKey();
            $version->versionable_type = method_exists($this, 'getMorphClass') ? $this->getMorphClass() : get_class($this);
            $version->user_id          = $this->getAuthUserId();

            $versionedHiddenFields = $this->versionedHiddenFields ?? [];
            $this->makeVisible($versionedHiddenFields);
            $version->model_data       = serialize($this->attributesToArray());
            $this->makeHidden($versionedHiddenFields);

            $version->reason = $this->reason ?? config('bricks-telling.default_reason', '');;


            $version->save();

            $this->purgeOldVersions();
        }
    }

    /**
     * Delete old versions of this model when the reach a specific count.
     *
     * @return void
     */
    private function purgeOldVersions()
    {
        $keep = isset($this->keepOldVersions) ? $this->keepOldVersions : 0;

        if ((int)$keep > 0) {
            $count = $this->versions()->count();

            if ($count > $keep) {
                $this->getLatestVersions()
                     ->take($count)
                     ->skip($keep)
                     ->get()
                     ->each(function ($version) {
                         $version->delete();
                     });
            }
        }
    }

    /**
     * Determine if a new version should be created for this model.
     *
     * @return bool
     */
    private function isValidForVersioning()
    {
        $dontVersionFields = isset( $this->dontVersionFields ) ? $this->dontVersionFields : [];
        $removeableKeys    = array_merge($dontVersionFields, [$this->getUpdatedAtColumn()]);

        if (method_exists($this, 'getDeletedAtColumn')) {
            $removeableKeys[] = $this->getDeletedAtColumn();
        }

        return ( count(array_diff_key($this->versionableDirtyData, array_flip($removeableKeys))) > 0 );
    }

    /**
     * @return int|null
     */
    protected function getAuthUserId()
    {
        return Auth::check() ? Auth::id() : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getLatestVersions()
    {
        return $this->versions()->orderByDesc('version_id');
    }
}

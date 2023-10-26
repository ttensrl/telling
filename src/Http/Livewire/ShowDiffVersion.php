<?php
/**
 * Created by PhpStorm.
 * Filename: ShowStoryTelling.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 30/12/21
 * Time: 17:41
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

namespace LaravelBricks\Telling\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use LaravelBricks\Telling\Models\Version;

class ShowDiffVersion extends Component
{

    /**
     * @var array
     */
    public $listOfField = [];

    /**
     * @var null
     */
    public $version = null;

    /**
     * @var array
     */
    public $field_version = [];

    /**
     * @var array
     */
    public $translatedField = [];

    /**
     * @var null
     */
    public $current = null;

    /**
     * @var null
     */
    public $all_versions = null;

    /**
     * @var int|null
     */
    public int|null $version_id = null;

    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var string[]
     */
    protected $listeners = ['open' => 'LoadDiff'];

    /**
     * Invocazione Principale
     *
     * @param $id
     *
     * @return void
     */
    public function LoadDiff($id = null)
    {
        $this->loadData($id);
        $this->toggleModal();
    }

    /**
     * Carica le proprietà delle versioni
     *
     * @param $id
     *
     * @return void
     */
    public function loadData($id = null)
    {
        if (isset($id)) {
            $this->version_id = $id;
        }

        $this->version       = Version::find($this->version_id);
        $this->current       = $this->version->versionable;
        $this->field_version = $this->normalizeFieldMultiLanguage($this->version);
        $this->all_versions = $this->current->versions()->orderBy('created_at', 'DESC')->get();
        $this->all_versions->shift();
    }

    /**
     * Refresha i dati della versione quando viene modificato la proprietà version_id
     *
     * @return void
     */
    public function updatedVersionId()
    {
        $this->loadData();
    }

    /**
     * Permette la chisura e l'apertura sincronizata della modale rispetto al component
     *
     * @return void
     */
    public function toggleModal()
    {
        if($this->show) {
            $this->emit('hideDiffModal');
            $this->show = false;
        } else {
            $this->emit('showDiffModal');
            $this->show = true;
        }
    }

    /**
     * Decodifia il campo json se il campo è realmente json ed è aggiunto il supporto per laravel spatie
     *
     * @param $version
     *
     * @return array
     */
    public function normalizeFieldMultiLanguage($version)
    {
        $current_version = [];
        foreach ($this->current->currentVersion()->diff($version) as $key => $value) {
            $json_decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && config('bricks-telling.support_spatie_translatable')) {
                $current_version[$key] = $json_decoded;
            } else {
                $current_version[$key] = $value;
            }
        }
        return $current_version;
    }

    /**
     * Render della vista Livewire
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('bricks-telling::livewire.show-diff-version-modal');
    }


}

<?php

namespace LaravelBricks\Telling;


use LaravelBricks\Telling\Http\Livewire\ShowDiffVersion;
use LaravelBricks\Telling\Http\Livewire\ShowStoryTelling;
use LaravelBricks\Telling\Views\Components\SelectVersion;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use Livewire\Livewire;

class TellingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/bricks-telling.php', 'bricks-telling'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bricks-telling');
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'bricks-telling');
        $this->publishingFile();
        $this->registerBladeComponent();
        Paginator::useBootstrap();
    }

    /**
     * File che possono esssere pubblicati fuori dal Package
     */
    public function publishingFile()
    {
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang/vendor/bricks-telling')], 'Bricks-Telling-Translations');
        $this->publishes([__DIR__.'/../config/bricks-telling.php' => config_path('bricks-telling.php')], 'Bricks-Telling-Config');
        $this->publishes([__DIR__.'/../resources/views/' => resource_path('views/vendor/bricks-telling')], 'Bricks-Telling-View');
        $this->publishes(
            [__DIR__.'/../database/migrations/create_versions_table.php' => $this->getMigrationFileName('create_versions_table.php')]
            , 'Bricks-Telling-Migration');
    }

    /**
     * Registra i componenti per i Template Blade
     */
    public function registerBladeComponent()
    {
        Livewire::component('telling', ShowStoryTelling::class);
        Livewire::component('diff-version', ShowDiffVersion::class);
    }


    /**
     * Copia il file della migration aggiungendo il timestamp attuale
     *
     * @return string
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');
        $filesystem = $this->app->make(Filesystem::class);
        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
                         ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                             return $filesystem->glob($path.'*_'.$migrationFileName);
                         })
                         ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
                         ->first();
    }
}

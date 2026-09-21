<?php

declare(strict_types=1);

namespace Pagelyne\Media\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pagelyne\Media\Contracts\MediaRepositoryInterface;
use Pagelyne\Media\Contracts\MediaStorageInterface;
use Pagelyne\Media\Repositories\MediaRepository;
use Pagelyne\Media\Services\MediaService;
use Pagelyne\Media\Services\MediaUploadService;
use Pagelyne\Media\Storage\LocalMediaStorage;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/media.php',
            'media'
        );

        $this->app->bind(
            MediaRepositoryInterface::class,
            MediaRepository::class
        );

        $this->app->bind(
            MediaStorageInterface::class,
            LocalMediaStorage::class
        );

        $this->app->singleton(
            MediaUploadService::class
        );

        $this->app->singleton(
            MediaService::class
        );
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->registerBladeComponents();
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register package views.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views',
            'media'
        );
    }

    /**
     * Register package Blade components.
     */
    protected function registerBladeComponents(): void
    {
        Blade::componentNamespace(
            'Pagelyne\\Media\\View\\Components',
            'media'
        );
    }

    /**
     * Register package migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../database/migrations'
        );
    }

    /**
     * Register package publishing.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/media.php' => config_path('media.php'),
            ], 'media-config');

            $this->publishes([
                __DIR__ . '/../../database/migrations' => database_path('migrations'),
            ], 'media-migrations');

            $this->publishes([
                __DIR__ . '/../../resources/views' => resource_path('views/vendor/media'),
            ], 'media-views');
        }
    }
}
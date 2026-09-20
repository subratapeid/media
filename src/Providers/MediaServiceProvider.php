<?php

declare(strict_types=1);

namespace Pagelyne\Media\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Pagelyne\Media\Services\MediaService;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/media.php',
            'media'
        );

        $this->app->singleton(MediaService::class, function ($app) {
            return new MediaService(
                config('media')
            );
        });
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerPublishables();
    }

    /**
     * Register package migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../Database/Migrations'
        );
    }

    /**
     * Register package routes.
     */
    protected function registerRoutes(): void
    {
        if (config('media.routes.enabled', true)) {
            $this->loadRoutesFrom(
                __DIR__ . '/../Routes/web.php'
            );
        }
    }

    /**
     * Register package views.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../Views',
            'media'
        );
    }

    /**
     * Register package translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../Lang',
            'media'
        );
    }

    /**
     * Register package publishable resources.
     */
    protected function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Config/media.php' => config_path('media.php'),
            ], 'media-config');

            $this->publishes([
                __DIR__ . '/../Database/Migrations' => database_path('migrations'),
            ], 'media-migrations');

            $this->publishes([
                __DIR__ . '/../Views' => resource_path('views/vendor/media'),
            ], 'media-views');

            $this->publishes([
                __DIR__ . '/../Lang' => lang_path('vendor/media'),
            ], 'media-lang');
        }
    }
}
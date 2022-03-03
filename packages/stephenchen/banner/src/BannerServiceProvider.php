<?php

namespace Stephenchen\Banner;

use Illuminate\Support\ServiceProvider;
use Stephenchen\Banner\Http\Backend\Banner\BannerRepository;
use Stephenchen\Banner\Http\Backend\Banner\BannerRepositoryInterface;

class BannerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'banner');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'banner');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Load database relate
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // load routers
        $this->loadRoutesFrom(__DIR__ . '/../routes/v1/backend.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/v1/frontend.php');

        $this->registerModelBindings();

        $this->loadTranslations();

        if ($this->app->runningInConsole()) {

            $this->offerPublishing();

            $this->registerMacroHelpers();

            $this->registerCommands();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'banner');

        // Register the main class to use with the facade
        $this->app->singleton('banner', function () {
            return new Banner;
        });
    }

    private function offerPublishing()
    {
//        $this->publishes([
//            __DIR__ . '/../config/config.php' => config_path('core.php'),
//        ], 'config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/core'),
        ], 'views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/core'),
        ], 'assets');*/
    }

    private function registerMacroHelpers()
    {

    }

    private function registerCommands()
    {
        $this->commands([

        ]);
    }

    private function registerModelBindings()
    {
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
    }

    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'core');
    }
}

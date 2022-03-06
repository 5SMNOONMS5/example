<?php

namespace Stephenchen\Member;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Stephenchen\Member\Http\Backend\MemberRepository;
use Stephenchen\Member\Http\Backend\MemberRepositoryInterface;

class MemberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @param Kernel $kernel
     */
    public function boot(Router $router, Kernel $kernel)
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'core');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'core');

        // Load database relate
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../database/seeders');

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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'member');

        // Register the main class to use with the facade
        $this->app->singleton('core', function () {
            return new Member;
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
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
    }

    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'members');
    }
}

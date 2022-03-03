<?php

namespace Stephenchen\Admin;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Stephenchen\Core\Commands\InitialCommandPart1;
use Stephenchen\Core\Commands\TestCommand;
use Stephenchen\Admin\Http\Backend\Admin\AdminRepository;
use Stephenchen\Admin\Http\Backend\Admin\AdminRepositoryInterface;
use Stephenchen\Admin\Http\Backend\Permission\PermissionRepository;
use Stephenchen\Admin\Http\Backend\Permission\PermissionRepositoryInterface;
use Stephenchen\Admin\Http\Backend\Role\RoleRepository;
use Stephenchen\Admin\Http\Backend\Role\RoleRepositoryInterface;
use Stephenchen\Core\Http\Middleware\AuthenticateAssignGuard;
use Stephenchen\Core\Http\Middleware\AuthenticateJwtVerify;
use Stephenchen\Core\Http\Middleware\SetLanguage;

class AdminServiceProvider extends ServiceProvider
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

        // cf. https://laracasts.com/discuss/channels/general-discussion/register-middleware-via-service-provider?page=2
        $router->aliasMiddleware('auth.jwt.verify', AuthenticateJwtVerify::class);
        $router->aliasMiddleware('auth.assign.guard', AuthenticateAssignGuard::class);
        $router->aliasMiddleware('set.language', SetLanguage::class);

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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'core');

        // Register the main class to use with the facade
        $this->app->singleton('core', function () {
            return new Core;
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
            InitialCommandPart1::class,
            TestCommand::class,
        ]);
    }

    private function registerModelBindings()
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'core');
    }
}

<?php namespace Saguajardo\BootstrapMenu;

use Illuminate\Support\ServiceProvider;
use Saguajardo\BootstrapMenu\Routes\RoutesBootstrapMenu;
use Saguajardo\BootstrapMenu\Commands\MakeMenuCommand;
use View;

class BootstrapMenuServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/config.php',
            'bootstrap-menu'
        );

        $this->registerBootstrapMenuHelper();

        $this->registerBootstrapMenuRoutes();

        // $this->registerMenuMakeCommand();

        $this->app->singleton('bootstrap-menu', function ($app) {

            return new BootstrapMenuBuilder($app, $app['bootstrap-menu-helper']);
        });

        $this->app->alias('bootstrap-menu', 'Saguajardo\BootstrapMenu\BootstrapMenuBuilder');
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMenuMakeCommand()
    {
        $this->app->singleton('command.menu.make', function ($app) {
            return new MakeMenuCommand;
        });
    }

    /**
     * Register the Routes for this package
     * 
     * @return void
     */
    protected function registerBootstrapMenuRoutes()
    {
        $this->app->singleton('bootstrap-menu-routes', function ($app) {

            return new RoutesBootstrapMenu();
        });

        $this->app->alias('bootstrap-menu-routes', 'Saguajardo\BootstrapMenu\Routes\RoutesBootstrapMenu');
    }

    protected function registerBootstrapMenuHelper()
    {
        $this->app->singleton('bootstrap-menu-helper', function ($app) {

            $configuration = $app['config']->get('bootstrap-menu');

            return new BootstrapMenuHelper($app['view'], $configuration);
        });

        $this->app->alias('bootstrap-menu-helper', 'Saguajardo\BootstrapMenu\BootstrapMenuHelper');
    }

    public function boot()
    {
        // cargar las vistas
        $this->loadViewsFrom(__DIR__.'/views', 'bootstrap-menu');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/bootstrap-menu'),
            __DIR__ . '/config/config.php' => config_path('bootstrap-menu.php')
        ]);

        $this->publishes([
            __DIR__ . '/migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->registerBladeExtensions();
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return ['bootstrap-menu'];
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->is{$expression}): ?>";
        });

        $blade->directive('endrole', function () {
            return "<?php endif; ?>";
        });

        $blade->directive('permission', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->can{$expression}): ?>";
        });

        $blade->directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        $blade->directive('level', function ($expression) {
            $level = trim($expression, '()');

            return "<?php if (Auth::check() && Auth::user()->level() >= {$level}): ?>";
        });

        $blade->directive('endlevel', function () {
            return "<?php endif; ?>";
        });

        $blade->directive('allowed', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->allowed{$expression}): ?>";
        });

        $blade->directive('endallowed', function () {
            return "<?php endif; ?>";
        });
    }

}

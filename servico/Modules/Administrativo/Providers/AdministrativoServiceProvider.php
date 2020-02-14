<?php

namespace Modules\Administrativo\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class AdministrativoServiceProvider
 * @package Modules\Administrativo\Providers
 */
class AdministrativoServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Guard::class, function () {
            return \Auth::guard('api');
        });

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Administrativo', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Administrativo', 'Config/config.php') => config_path('administrativo.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Administrativo', 'Config/config.php'), 'administrativo'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/administrativo');

        $sourcePath = module_path('Administrativo', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/administrativo';
        }, \Config::get('view.paths')), [$sourcePath]), 'administrativo');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/administrativo');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'administrativo');
        } else {
            $this->loadTranslationsFrom(module_path('Administrativo', 'Resources/lang'), 'administrativo');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Administrativo', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

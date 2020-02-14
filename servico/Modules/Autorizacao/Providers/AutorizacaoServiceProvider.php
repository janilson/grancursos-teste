<?php

namespace Modules\Autorizacao\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Autorizacao\Entities\Allowable;

class AutorizacaoServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Allowable::class, function () {
            return auth()->user();
        });
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Autorizacao', 'Database/Migrations'));
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
            module_path('Autorizacao', 'Config/config.php') => config_path('autorizacao.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Autorizacao', 'Config/config.php'), 'autorizacao'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/autorizacao');

        $sourcePath = module_path('Autorizacao', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/autorizacao';
        }, \Config::get('view.paths')), [$sourcePath]), 'autorizacao');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/autorizacao');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'autorizacao');
        } else {
            $this->loadTranslationsFrom(module_path('Autorizacao', 'Resources/lang'), 'autorizacao');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Autorizacao', 'Database/factories'));
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

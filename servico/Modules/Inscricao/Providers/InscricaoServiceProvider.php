<?php

namespace Modules\Inscricao\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Inscricao\Console\BloqueioInscricao;

/**
 * Class InscricaoServiceProvider
 * @package Modules\Inscricao\Providers
 */
class InscricaoServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Inscricao', 'Database/Migrations'));

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->commands([
            BloqueioInscricao::class
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Inscricao', 'Config/config.php') => config_path('inscricao.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Inscricao', 'Config/config.php'), 'inscricao'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/inscricao');

        $sourcePath = module_path('Inscricao', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/inscricao';
        }, \Config::get('view.paths')), [$sourcePath]), 'inscricao');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/inscricao');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'inscricao');
        } else {
            $this->loadTranslationsFrom(module_path('Inscricao', 'Resources/lang'), 'inscricao');
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
            app(Factory::class)->load(module_path('Inscricao', 'Database/factories'));
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

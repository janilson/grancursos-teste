<?php

namespace Modules\Autenticacao\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Autenticacao\Console\GerarSenhaCommand;
use Modules\Autenticacao\Repository\UsuarioRepository;
use Modules\Autenticacao\Repository\UsuarioRepositoryInterface;

/**
 * Class AutenticacaoServiceProvider
 * @package Modules\Autenticacao\Providers
 */
class AutenticacaoServiceProvider extends ServiceProvider
{
    const AUTENTICACAO = 'autenticacao';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        \Auth::provider('autenticacao', function () {
            return new AutenticacaoProvider();
        });

        $this->app->bind(Guard::class, function () {
            return \Auth::guard('api');
        });

        $this->app->bind(UsuarioRepositoryInterface::class, function () {
            return app(UsuarioRepository::class);
        });

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
                GerarSenhaCommand::class,
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
            __DIR__ . '/../Config/config.php' => config_path('autenticacao.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', self::AUTENTICACAO
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/autenticacao');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/autenticacao';
        }, \Config::get('view.paths')), [$sourcePath]), self::AUTENTICACAO);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/autenticacao');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, self::AUTENTICACAO);
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', self::AUTENTICACAO);
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
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

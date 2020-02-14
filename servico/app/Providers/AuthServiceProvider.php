<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Providers\SaaUserProvider;
use \Modules\Autenticacao\Service\Saa;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        \Auth::provider('saa', function () {
//            return new SaaUserProvider(app(Usuario::class), app(Saa::class));
//        });
    }
}

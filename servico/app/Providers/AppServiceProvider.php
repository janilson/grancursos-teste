<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('cpf_formatado', function ($expression) {
            return "<?php echo preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '\$1.\$2.\$3-\$4', $expression); ?>";
        });

        \Blade::directive('telefone_formatado', function ($expression) {
            return "<?php echo preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $expression); ?>";
        });

        \Blade::directive('quebra_email', function ($expression) {
            return "<?php echo substr($expression, 0, 22) . \"\n\" . substr($expression, 22); ?>";
        });

        /*
         * sub-query join Oracle
         */
        Builder::macro('joinSubOracle', function ($query, $as, $first, $operator = null, $second = null, $type = 'inner', $where = false) {
            [$query, $bindings] = $this->createSub($query);

            $expression = '(' . $query . ') ' . $as;

            $this->addBinding($bindings, 'join');

            return $this->join(new Expression($expression), $first, $operator, $second, $type, $where);
        });
    }
}

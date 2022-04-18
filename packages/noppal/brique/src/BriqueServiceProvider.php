<?php

namespace Npl\Brique;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BriqueServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadViewsFrom(__DIR__.'/../../../noppal-brique/resources/views/layout', 'npl-layout');
        // $this->publishes([
        //     __DIR__.'/../../../noppal-brique/resources/views/noppal_brique' => resource_path('views/vendor/noppal-brique'),
        // ]);

        //views
        $this->loadViewsFrom(__DIR__.'/../views', 'npl');
        Blade::componentNamespace('Npl\Brique\View\Components', 'npl');
        
        //migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }
}

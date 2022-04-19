<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Npl\Brique\View\Components\Generic\Bagde\Badge;

class AppServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../../../noppal-brique/resources/views/layout', 'npl-layout');
        // $this->publishes([
        //     __DIR__.'/../../../noppal-brique/resources/views/noppal_brique' => resource_path('views/vendor/noppal-brique'),
        // ]);
        Blade::componentNamespace('Npl\Brique\View\Components', 'npl');
    }
}

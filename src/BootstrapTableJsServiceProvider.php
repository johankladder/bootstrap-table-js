<?php
/**
 * Created by PhpStorm.
 * User: johankladder
 * Date: 19-11-17
 * Time: 19:17
 */

namespace JohanKladder\BootstrapTableJs;


use Illuminate\Support\ServiceProvider;

class BootstrapTableJsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'bootstrap-table-js');

        $this->publishes([
            __DIR__.'/assets' => resource_path('assets/js/bootstrap-table-js'),
            __DIR__.'/assets/style.css' => public_path('bootstrap-table-js/css/style.css'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
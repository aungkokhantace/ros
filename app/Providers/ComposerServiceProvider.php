<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers
        view()->composer('cashier.layouts.partial.header', function ($view) {
            $headerData = \DB::table('config')->first();
//            dd($headerData);
            $view->headerData = $headerData;

        });

        view()->composer('cashier.layouts.kitchen.header', function ($view) {
            $headerData = \DB::table('config')->first();
//            dd($headerData);
            $view->headerData = $headerData;
            
        });
    }

    /**userlist
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

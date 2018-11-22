<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }
    private function getConfigPath()
    {
        return dirname(__DIR__, 2) . '/config/https.php';
    }
}

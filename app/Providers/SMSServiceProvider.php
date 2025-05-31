<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SMSService;
class SMSServiceProvider extends ServiceProvider
{
    /**
    
     * Register any application services.
     *
     * @return void
     */
     

    
    public function register()
    {
        
        $this->app->singleton(SMSService::class, function ($app) {
            return new SMSService();
        });



    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

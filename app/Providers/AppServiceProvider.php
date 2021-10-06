<?php

namespace App\Providers;

use App\Models\Match;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        app()->singleton('lang',function (){
            if(session()->has('lang')){
                return session()->get('lang');
            }// session lang exist
            else{
                return 'ar';
            }
        });
        Schema::defaultStringLength(191);
        view()->share('settings', Setting::first());

    }
}

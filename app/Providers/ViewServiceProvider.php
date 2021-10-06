<?php

namespace App\Providers;


use App\Models\Setting;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //share the following variables data with Admin Routes only
//        view()->composer(['admin.*'], function ($view)
//        {
//            //setting
//            $view->with([
//                'unread_messages'=>\App\Models\Contact::where('is_read','unread')->get(),
////                'unread_notifications'=>\App\Models\AdminNotification::latest()->get(),
////                'unread_notifications_count'=>\App\Models\AdminNotification::where('is_read','unread')->count(),
////
//            ]);
//
//        });//end view function
//
   }
}

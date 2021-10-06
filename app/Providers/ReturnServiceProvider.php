<?php

namespace App\Providers;

use App\Http\interfaces\AdminInterface;
use App\Http\interfaces\DashboardInterface;
use App\Http\interfaces\OrdersInterface;
use App\Http\interfaces\SettingInterface;
use App\Http\interfaces\UsersInterface;
use App\Http\repositories\AdminRepository;
use App\Http\repositories\DashboardRepository;
use App\Http\repositories\OrdersRepository;
use App\Http\repositories\SettingRepository;
use App\Http\repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class ReturnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

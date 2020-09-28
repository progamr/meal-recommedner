<?php

namespace App\Providers;

use App\Repositories\Contracts\RestaurantRepositoryInterface;
use App\Repositories\Restaurant\RestaurantRepository;
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
        // Repositories
        $this->app->singleton(RestaurantRepositoryInterface::class, RestaurantRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

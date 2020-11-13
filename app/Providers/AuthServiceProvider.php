<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Product;
use App\Policies\ProductPolicy;
use App\Category;
use App\Policies\CategoryPolicy;
use App\Restaurant;
use App\Policies\RestaurantPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [ 
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Restaurant::class => RestaurantPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

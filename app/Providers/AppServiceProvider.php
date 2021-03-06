<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['partial.mainav','home'], function($view){
            $categories = Category::with(['products','allSubCategories.products'])->orderBy('order')->where('parent_id',null)->get();
            
            $view->with('categories', $categories);
        });
        view()->composer('partial.cart', function($view){
            $view->with('cart', session('cart', []));
        });

        view()->composer('partial.pagetop', function($view){
            $isLoggedIn = Auth::check();
            $user = $isLoggedIn ? Auth::user()->getUserInfo() : false;
            $view->with(compact(['isLoggedIn','user']));
        });

        Horizon::auth(function ($request) {
            return true;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Auth0\Login\Contract\Auth0UserRepository::class, 
            \Auth0\Login\Repository\Auth0UserRepository::class
        );
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Dealer;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use DB;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $getTotalProductAdded = 0;
            if (Auth::check()) {
                $currentuserid = Auth::id();
                $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
                $view->with('totalCartCount' , $getTotalProductAdded);
            } else {
                $view->with('totalCartCount' , $getTotalProductAdded);
            }
        });
    }
}

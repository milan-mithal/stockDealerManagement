<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Dealer;
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
        $getTotalProductAdded = 0;

        view()->composer('*', function ($view) {
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

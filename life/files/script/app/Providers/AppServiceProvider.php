<?php

namespace App\Providers;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);

        View::composer(["layouts.frontend.app"], function ($view) {
            $view->with("settings", Cache::rememberForever("settings", function () {
                return Option::where('key', 'theme_settings')->first();
            }));
        });

    }
}

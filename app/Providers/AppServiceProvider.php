<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
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
        $this->app->instance('path.lang', $this->app->basePath() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'lang');

        // config(['services.facebook.client_id' => setting('facebook_app_id')]);
        // config(['services.facebook.client_secret' => setting('facebook_app_secret')]);
        // config(['services.facebook.redirect' => url('auth/facebook/callback')]);

        // config(['services.google.client_id' => setting('google_app_id')]);
        // config(['services.google.client_secret' => setting('google_app_secret')]);
        // config(['services.google.redirect' => url('auth/google/callback')]);

        // config(['app.search_tags_key' => "#"]);
        config(['app.languages' => [
            'en' => 'English',
            'ar' => 'Arabic',
            'fr' => 'Franch'
        ]]);


        // share data
        view()->composer('*', function($view) {
            if (Auth::check()) {
                View::share('cartid', Auth::id());
                View::share('countCart', Cart::where('user_id', Auth::id() )->sum('quantity'));
            }else {
                View::share('cartid', 0);
                View::share('countCart', 0);
            }
        });
    }
}

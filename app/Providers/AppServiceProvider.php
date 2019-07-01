<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Topic;

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
        Topic::observe(\App\Observers\TopicObserver::class);
    }
}

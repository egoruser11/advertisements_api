<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Observers\AssessmentObserver;
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
        Assessment::observe(AssessmentObserver::class);
    }
}

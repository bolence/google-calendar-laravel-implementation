<?php

namespace App\Providers;

use App\Interfaces\CalendarInterface;
use App\Services\GoogleCalendar;
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
        $this->app->bind(CalendarInterface::class, GoogleCalendar::class);
    }
}

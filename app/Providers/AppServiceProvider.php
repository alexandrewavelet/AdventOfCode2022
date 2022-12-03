<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        str()->macro('pascal', function (string $value): string {
            return ucfirst(str($value)->camel());
        });
    }
}

<?php

namespace RicardoSnery\NLoading;

use Illuminate\Support\ServiceProvider;

class NLoadingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nloading.php', 'nloading');
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'nloading');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nloading');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/nloading.php' => config_path('nloading.php'),
            ], 'nloading-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/nloading'),
            ], 'nloading-views');
        }
    }
}

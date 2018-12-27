<?php

namespace CarroPublic\LaravelTwilio;

use Illuminate\Support\ServiceProvider;

class LaravelTwilioServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/laraveltwilio.php' => config_path('laraveltwilio.php'),
            ], 'laraveltwilio.config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laraveltwilio.php', 'laraveltwilio');

        // Register the service the package provides.
        $this->app->singleton('laraveltwilio', function ($app) {
            return new LaravelTwilio;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laraveltwilio'];
    }
}
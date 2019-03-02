<?php

namespace hosomikai\spgateway;

use Illuminate\Support\ServiceProvider;

class SpgatewayServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'hosomikai');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'hosomikai');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/spgateway.php', 'spgateway');

        // Register the service the package provides.
        $this->app->singleton('spgateway', function ($app) {
            return new SPGatewayManager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['spgateway'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/spgateway.php' => config_path('spgateway.php'),
        ], 'spgateway.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/hosomikai'),
        ], 'spgateway.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/hosomikai'),
        ], 'spgateway.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/hosomikai'),
        ], 'spgateway.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

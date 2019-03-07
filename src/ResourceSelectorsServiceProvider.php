<?php

namespace Mujiciok\ResourceSelectors;

use Illuminate\Support\ServiceProvider;
use Mujiciok\ResourceSelectors\Console\ResourceWithSelectorsMakeCommand;

class ResourceSelectorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'resource-selectors');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'resource-selectors');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('resource-selectors.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/resource-selectors'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/resource-selectors'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/resource-selectors'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(
        	__DIR__.'/../config/config.php', 
        	'resource-selectors'
        );

//        $this->commands([
//            ResourceWithSelectorsMakeCommand::class,
//        ]);
        $this->commands(ResourceWithSelectorsMakeCommand::class);

        $this->app->bind(Filesystem::class, function () {
            return new Filesystem($this->app->make('filesystem'));
        });

        // Register the main class to use with the facade
        $this->app->singleton('resource-selectors', function () {
            return new ResourceSelectors;
        });
    }
}

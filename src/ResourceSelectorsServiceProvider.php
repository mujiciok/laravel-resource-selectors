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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-resource-selectors.php'),
            ], 'config');
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
        	'laravel-resource-selectors'
        );

        $this->commands(ResourceWithSelectorsMakeCommand::class);

        $this->app->bind(Filesystem::class, function () {
            return new Filesystem($this->app->make('filesystem'));
        });

        // Register the main class to use with the facade
        $this->app->singleton('laravel-resource-selectors', function () {
            return new ResourceSelectors;
        });
    }
}

<?php

namespace Pythagus\LaravelLogger;

use Illuminate\Support\ServiceProvider;

/**
 * Class LoggerServiceProvider
 * @package Pythagus\LaravelLogger
 *
 * @author: Damien MOLINA
 */
class LoggerServiceProvider extends ServiceProvider {

    /**
     * Package slug in the Laravel artisan tool.
     *
     * @const string
     */
    private const PACKAGE_SLUG = 'logger' ;

    /**
     * Default config file.
     *
     * @const string
     */
    private const CONFIG_FILE = __DIR__ . '/config.php' ;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(LoggerServiceProvider::CONFIG_FILE, LoggerServiceProvider::PACKAGE_SLUG) ;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            LoggerServiceProvider::CONFIG_FILE => config_path('logger.php')
        ], LoggerServiceProvider::PACKAGE_SLUG . '-config') ;

        // Add the log listeners.
        Logger::database()->listener() ;
        Logger::job()->listenFailingJobs() ;
        Logger::job()->listenProcessingJobs() ;
        Logger::scheduledTask()->listeners() ;
        Logger::command()->listeners() ;
    }
}
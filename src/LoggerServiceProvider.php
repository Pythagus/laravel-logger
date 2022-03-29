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
        $this->mergeConfigFrom(
            LoggerServiceProvider::CONFIG_FILE, $this->packageKey()
        ) ;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->publish(
            LoggerServiceProvider::CONFIG_FILE, config_path($this->packageKey().'.php'), 'config'
        ) ;
    }
  
    /**
     * Get the package key for the Laravel artisan.
     *
     * @param string|null $key
     * @return string
     */
    private function packageKey(string $key = null) {
        return LoggerServiceProvider::PACKAGE_SLUG . (is_null($key) ? "" : '-' . $key) ;
    }

    /**
     * Publish the given file.
     *
     * @param string $file
     * @param string $destination
     * @param string|null $group
     */
    private function publish(string $file, string $destination, string $group = null) {
        $this->publishes([$file => $destination], $group ? $this->packageKey($group) : null) ;
    }
}
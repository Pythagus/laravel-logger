<?php

namespace Pythagus\LaravelLogger\Loggers;

use Pythagus\LaravelLogger\Logger;
use Pythagus\LaravelLogger\Http\LoggerMiddleware;
use Pythagus\LaravelLogger\Loggers\Support\UuidCache;

/**
 * Class AbstractLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
abstract class AbstractLogger {

    /**
     * UUID field key in the array.
     * 
     * @var string
     */
    public const UUID = 'uuid' ;

    /**
     * Logger type to identify logs in the
     * receiving server.
     *
     * @var string
     */
    public static $type ;

    /**
     * UUID cache instance.
     *
     * @var UuidCache
     */
    protected $uuid ;

    /**
     * Convert the given object to an array.
     *
     * @param object $object
     */
    abstract public static function objectToArray(object $object): array ;

    /**
     * Create a new logger instance.
     * 
     * @return static
     */
    public function __construct() {
        $this->uuid = new UuidCache() ;
    }

    /**
     * Send the object to the Logger server.
     *
     * @param object $object
     * @param array $additionalData
     * @return void
     */
    public function register(object $object, array $additionalData = []) {
        // Don't do anything if the logger is
        // not enabled.
        if(! config('logger.enabled', false)) {
            return ;
        }

        // Merge all the data into a single array and
        // send it through the logger.
        Logger::send(array_merge([
            'uuid' => $additionalData[static::UUID] ?? null,
            'type' => static::$type,
        ], static::objectToArray($object), $additionalData)) ;
    }
}

<?php

namespace Pythagus\LaravelLogger\Loggers;

use Pythagus\LaravelLogger\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        // If there is a UUID in the additional data, then
        // keep it. If not, then generates a new value.
        $uuid = array_key_exists(static::UUID, $additionalData) ? [] : [
            'uuid' => LoggerMiddleware::getRequestUuid(request()),
        ] ;

        // Merge all the data into a single array and
        // send it through the logger.
        Logger::send(
            array_merge($uuid, static::objectToArray($object), $additionalData)
        ) ;
    }

    /**
     * Get the header interesting values.
     *
     * @param Request|Response $object
     * @return void
     */
    protected function getHttpHeader($object) {
        return [
            'user-agent' => $object->headers->get('user-agent'),
            'accept'     => $object->headers->get('accept'),
        ] ;
    }
}

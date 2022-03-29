<?php

namespace Pythagus\LaravelLogger\Loggers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class ResponseLogger extends AbstractLogger {

    /**
     * Class the object must be instance of.
     * Leave empty to bypass the test.
     *
     * @var string|null
     */
    protected $class = Response::class ;

    /**
     * Convert the given response to an array.
     *
     * @param Response $response
     */
    protected function objectAsArray($response): array {
        return [] ; // TODO
    }
}

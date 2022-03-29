<?php

namespace Pythagus\LaravelLogger\Loggers;

use Illuminate\Http\Request;

/**
 * Class RequestLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class RequestLogger extends AbstractLogger {

    /**
     * Class the object must be instance of.
     * Leave empty to bypass the test.
     *
     * @var string|null
     */
    protected $class = Request::class ;

    /**
     * Convert the given request to an array.
     *
     * @param Request $request
     */
    protected function objectAsArray($request): array {
        return [] ; // TODO
    }
}

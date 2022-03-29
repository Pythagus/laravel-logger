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
        return [
            'uuid'   => $this->getRequestUuid($request),
            'header' => $request->headers->all(),
            'url'    => [
                'scheme' => $request->getScheme(),
                'host'   => $request->getHttpHost(),
                'uri'    => $request->path(),
                'secure' => $request->secure(),
            ],
            'user' => $request->user()->toArray()
        ] ;
    }
}

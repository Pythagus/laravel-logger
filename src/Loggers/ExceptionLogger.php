<?php

namespace Pythagus\LaravelLogger\Loggers;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Pythagus\LaravelLogger\Logger;
use Pythagus\LaravelLogger\Http\LoggerMiddleware;

/**
 * Class ExceptionLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class ExceptionLogger extends AbstractLogger {

    /**
     * Logger type to identify logs in the
     * receiving server.
     *
     * @var string
     */
    public static $type = 'EXCEPTION' ;

    /**
     * Convert the given throwable to an array.
     *
     * @param Throwable $throwable
     */
    public static function objectToArray($throwable): array {
        return [
            'code'    => $throwable->getCode(),
            'line'    => $throwable->getLine(),
            'message' => $throwable->getMessage(),
            'file'    => $throwable->getFile(),
            'name'    => get_class($throwable),
        ] ;
    }

    /**
     * Get the exception logger closure.
     *
     * @return Closure
     */
    public function closure() {
        return function(Throwable $throwable, Request $request = null) {
            if($request) {
                // The exception occured before the HTTP kernel
                // was put in place. So the middleware was never
                // called.
                if(! $request->headers->has(LoggerMiddleware::HEADER_KEY)) {
                    $request->headers->set(LoggerMiddleware::HEADER_KEY, LoggerMiddleware::getRequestUuid($request)) ;

                    Logger::request($request) ;
                }
            }

            $this->register($throwable) ;
        } ;
    }
}

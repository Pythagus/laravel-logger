<?php

namespace Pythagus\LaravelLogger;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Pythagus\LaravelLogger\Loggers\RequestLogger;
use Pythagus\LaravelLogger\Loggers\ResponseLogger;
use Pythagus\LaravelLogger\Loggers\DatabaseQueryLogger;

/**
 * Class Logger
 * @package Pythagus\LaravelLogger
 *
 * @author: Damien MOLINA
 */
class Logger {

    /**
     * Create a new DatabaseQueryLogger instance.
     *
     * @return DatabaseQueryLogger
     */
    public static function database() {
        return new DatabaseQueryLogger() ;
    }

    /**
     * Register a new request.
     *
     * @param Request $request
     * @return void
     */
    public static function request(Request $request) {
        return (new RequestLogger())->register($request) ;
    }

    /**
     * Register a new response.
     *
     * @param Response $response
     * @return void
     */
    public static function response(Response $response) {
        return (new ResponseLogger())->register($response) ;
    }
}
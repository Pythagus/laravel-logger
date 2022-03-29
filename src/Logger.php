<?php

namespace Pythagus\LaravelLogger;

use Throwable;
use anlutro\cURL\cURL;
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

    /**
     * Make a cURL call to send the given 
     * array data.
     *
     * @param array $data
     * @return void
     */
    public static function send(array $data) {
        try {
            $request = (new cURL())->newJsonRequest('POST', 'localhost', $data) ;
            $request->setHeader('x-api-key', 'KEY') ;
            $request->send() ;
        } catch(Throwable $ignored) {}
    }
}
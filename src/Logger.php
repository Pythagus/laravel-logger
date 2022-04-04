<?php

namespace Pythagus\LaravelLogger;

use Throwable;
use anlutro\cURL\cURL;
use Illuminate\Http\Request;
use Pythagus\LaravelLogger\Loggers\JobLogger;
use Symfony\Component\HttpFoundation\Response;
use Pythagus\LaravelLogger\Loggers\RequestLogger;
use Pythagus\LaravelLogger\Loggers\ResponseLogger;
use Pythagus\LaravelLogger\Loggers\ExceptionLogger;
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
     * Create a new ExceptionLogger instance.
     *
     * @return ExceptionLogger
     */
    public static function error() {
        return new ExceptionLogger() ;
    }

    /**
     * Create a new JobLogger instance.
     *
     * @return JobLogger
     */
    public static function job() {
        return new JobLogger() ;
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
            // TODO to delete
            FileLogger::report($data) ;

            echo "<pre>" ;
            var_dump($data) ;
            //exit ;

            $request = (new cURL())->newJsonRequest('POST', 'localhost', $data) ;
            $request->setHeader('x-api-key', 'KEY') ;
            $request->send() ;
        } catch(Throwable $ignored) {}
    }
}
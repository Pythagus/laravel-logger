<?php

namespace Pythagus\LaravelLogger;

use Throwable;
use anlutro\cURL\cURL;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Pythagus\LaravelLogger\Loggers\CommandLogger;
use Pythagus\LaravelLogger\Loggers\JobLogger;
use Symfony\Component\HttpFoundation\Response;
use Pythagus\LaravelLogger\Loggers\RequestLogger;
use Pythagus\LaravelLogger\Loggers\ResponseLogger;
use Pythagus\LaravelLogger\Loggers\ExceptionLogger;
use Pythagus\LaravelLogger\Loggers\DatabaseQueryLogger;
use Pythagus\LaravelLogger\Loggers\ScheduledTaskLogger;

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
     * Create a new ScheduledTaskLogger instance.
     *
     * @return ScheduledTaskLogger
     */
    public static function scheduledTask() {
        return new ScheduledTaskLogger() ;
    }

    /**
     * Create a new CommandLogger instance.
     * 
     * @return CommandLogger
     */
    public static function command() {
        return new CommandLogger() ;
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
            var_dump($data) ;
            
            $request = (new cURL())->newJsonRequest('POST', config('logger.url'), $data) ;
            $request->setHeader('Accept', 'application/json') ;
            $request->setHeader('X-API-KEY', config('logger.key'), true) ;
            //$response = $request->send() ;

            //echo "<pre>" ;
            //var_dump($response) ;
            //exit ;
        } catch(Throwable $ignored) {}
    }

    /**
     * Generate a UUID.
     *
     * @return string
     */
    public static function generateUuid() {
        return Str::uuid()->toString() ;
    }
}
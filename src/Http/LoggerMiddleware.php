<?php

namespace Pythagus\LaravelLogger\Http;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pythagus\LaravelLogger\Logger;

/**
 * Class LoggerMiddleware.
 * @package Pythagus\LaravelLogger\Http
 *
 * @author: Damien MOLINA
 */
class LoggerMiddleware {

    /**
     * Header key used to store the request identifier.
     * 
     * @var string
     */
    public const HEADER_KEY = 'X-Request-ID' ;

    /**
     * Add the Request ID header if needed.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next) {
        $uuid = LoggerMiddleware::getRequestUuid($request) ;
        $_SERVER['HTTP_X_REQUEST_ID'] = $uuid ;
        $request->headers->set(LoggerMiddleware::HEADER_KEY, $uuid) ;

        Logger::request($request) ;
        $response = $next($request) ;

        if($response) {
            $response->headers->set(LoggerMiddleware::HEADER_KEY, $uuid) ;
            Logger::response($response) ;
        }

        return $response ;
    }

    /**
     * Get the request UUID.
     *
     * @param Request $request
     * @return string
     */
    public static function getRequestUuid(Request $request) {
        $uuid = $request->headers->get(LoggerMiddleware::HEADER_KEY) ;

        if(is_null($uuid)) {
            $uuid = Str::uuid()->toString() ;
        }

        return $uuid ;
    }
}
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
     * Add the Request ID header if needed.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next) {
        $uuid = $this->getRequestUuid($request) ;
        $_SERVER['HTTP_X_REQUEST_ID'] = $uuid ;
        $request->headers->set('X-Request-ID', $uuid) ;

        Logger::request($request) ;
        $response = $next($request) ;
        $response->headers->set('X-Request-ID', $uuid) ;
        Logger::response($response) ;

        return $response ;
    }

    /**
     * Get the request UUID.
     *
     * @param Request $request
     * @return string
     */
    protected function getRequestUuid(Request $request) {
        $uuid = $request->headers->get('X-Request-ID') ;

        if(is_null($uuid)) {
            $uuid = Str::uuid()->toString() ;
        }

        return $uuid ;
    }
}
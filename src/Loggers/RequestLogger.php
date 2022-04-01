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
        $user = $request->user() ;
        $data = [
            'header' => [
                'user-agent' => $request->headers->get('user-agent'),
                'accept'     => $request->headers->get('accept'),
            ],
            'cookie' => $request->cookies->all(),
            'locale' => $request->getLocale(),
            'url'    => [
                'scheme' => $request->getScheme(),
                'host'   => $request->getHttpHost(),
                'uri'    => $request->path(),
                'secure' => $request->secure(),
            ],
            'route'   => null,
            'method'  => $request->getMethod(),
            'version' => $request->getProtocolVersion(),
            'ip'      => $request->ip(),
            'user'    => $user ? $user->toArray() : null,
            'content' => $request->except('password', 'password_confirmation'),
        ] ;

        // Route can be null when an exception occured
        // before the HTTP kernel was loaded.
        $route = $request->route() ;
        if($route) {
            $data['route'] = [
                'name'       => $route->getName() ?? null,
                'parameters' => $route->parameters(),
                'middleware' => $route->middleware(),
                'controller' => class_basename($route->getAction('controller')),
            ] ;
        }

        return $data ;
    }
}

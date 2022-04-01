<?php

namespace Pythagus\LaravelLogger\Loggers;

use Pythagus\LaravelLogger\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pythagus\LaravelLogger\Http\LoggerMiddleware;

/**
 * Class AbstractLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
abstract class AbstractLogger {

    /**
     * Class the object must be instance of.
     * Leave empty to bypass the test.
     *
     * @var string|null
     */
    protected $class = null ;

    /**
     * Convert the given object to an array.
     *
     * @param object $object
     */
    abstract protected function objectAsArray(object $object): array ;

    /**
     * Send the object to the Logger server.
     *
     * @param object $object
     * @return void
     */
    public function register(object $object) {
        if(! empty($this->class) && ! ($object instanceof $this->class)) {
            // TODO send an error log.
            return ;
        }

        $data = array_merge([
            'uuid' => LoggerMiddleware::getRequestUuid(request()),
        ], $this->objectAsArray($object)) ;

        Logger::send($data) ;
    }

    /**
     * Get the header interesting values.
     *
     * @param Request|Response $object
     * @return void
     */
    protected function getHttpHeader($object) {
        return [
            'user-agent' => $object->headers->get('user-agent'),
            'accept'     => $object->headers->get('accept'),
        ] ;
    }
}

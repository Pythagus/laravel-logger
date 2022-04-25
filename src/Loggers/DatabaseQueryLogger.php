<?php

namespace Pythagus\LaravelLogger\Loggers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;

/**
 * Class DatabaseQueryLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class DatabaseQueryLogger extends AbstractLogger {

    /**
     * Class the object must be instance of.
     * Leave empty to bypass the test.
     *
     * @var string|null
     */
    protected $class = QueryExecuted::class ;

    /**
     * Convert the given object to an array.
     *
     * @param QueryExecuted $event
     */
    public static function objectToArray($event): array {
        return [
            'query' => [
                'sql'            => $event->sql,
                'bindings'       => $event->bindings,
                'execution_time' => $event->time,
            ],
        ] ;
    }

    /**
     * Set the database query listener.
     *
     * @return void
     */
    public function listener() {
        DB::listen(function(QueryExecuted $event) {
            $this->register($event) ;
        }) ;
    }
}

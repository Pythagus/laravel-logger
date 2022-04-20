<?php

namespace Pythagus\LaravelLogger\Loggers\Support;

use Pythagus\LaravelLogger\Logger;

/**
 * Class UuidCache
 * @package Pythagus\LaravelLogger\Loggers\Support
 *
 * @author: Damien MOLINA
 */
class UuidCache {

    /**
     * Keep in a variable a list of the
     * found scheduled tasks to retrieve
     * the uuid.
     *
     * @var array
     */
    protected $arr = [] ;

    /**
     * Get the task UUID and put the value in
     * the cache to retrieve it later if not
     * already exists.
     *
     * @param string $key
     * @return string
     */
    public function get(string $key) {
        // If the key doesn't exist in the cache,
        // then add an entry.
        if(! array_key_exists($key, $this->arr)) {
            $this->arr[$key] = Logger::generateUuid() ;
        }

        return $this->arr[$key] ;
    }

    /**
     * Remove a key from the cache.
     *
     * @param string $key
     * @return void
     */
    public function remove(string $key) {
        unset($this->arr[$key]) ;
    }
}

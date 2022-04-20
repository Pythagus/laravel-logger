<?php

namespace Pythagus\LaravelLogger\Loggers;

use Illuminate\Support\Facades\Event;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Events\CommandFinished;
use Pythagus\LaravelLogger\Contracts\CommandContract;

/**
 * Class CommandLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class CommandLogger extends AbstractLogger implements CommandContract {

    /**
     * Class the object must be instance of.
     * Leave empty to bypass the test.
     *
     * @var string|null
     */
    protected $class = null ;

    /**
     * Convert the given event to an array.
     *
     * @param CommandStarting|CommandFinished $event
     */
    protected function objectAsArray($event): array {
        return [
            'command' => $event->command,
        ] ;
    }

    /**
     * Get the id of the event.
     *
     * @param CommandStarting|CommandFinished $event
     * @return string
     */
    protected function id($event) {
        return md5($event->command) ;
    }

    /**
     * Send the object to the Logger server.
     *
     * @param ScheduledTaskStarting|ScheduledTaskFinished|ScheduledTaskFailed $event
     * @param array $additionalData
     * @return void
     */
    protected function registerType($event, string $type, array $additionalData = []) {
        return $this->register($event, array_merge([
            'type'       => $type,
            static::UUID => $this->uuid->get($this->id($event)),
        ], $additionalData)) ;
    }

    /**
     * Set up the event listeners.
     *
     * @return void
     */
    public function listeners() {
        // For a starting task.
        Event::listen(CommandStarting::class, function(CommandStarting $event) {
            $this->registerType($event, static::TYPE_STARTED) ;
        }) ;

        // For a finished task.
        Event::listen(CommandFinished::class, function(CommandFinished $event) {
            $this->registerType($event, static::TYPE_FINISHED, ['exitCode' => $event->exitCode]) ;
            $this->uuid->remove($this->id($event)) ;
        }) ;
    }   
}

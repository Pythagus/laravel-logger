<?php

namespace Pythagus\LaravelLogger\Loggers;

use Illuminate\Support\Facades\Event;
use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Pythagus\LaravelLogger\Contracts\CommandContract;
use \Illuminate\Console\Scheduling\Event as ScheduledEvent;

/**
 * Class ScheduledTaskLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class ScheduledTaskLogger extends AbstractLogger implements CommandContract {

    /**
     * Convert the given event to an array.
     *
     * @param ScheduledEvent $event
     */
    public static function objectToArray($event): array {
        return [
            'task' => [
                'command'    => $event->command,
                'expression' => $event->expression,
                'exitCode'   => $event->exitCode,
            ],
        ] ;
    }

    /**
     * Send the object to the Logger server.
     *
     * @param ScheduledTaskStarting|ScheduledTaskFinished|ScheduledTaskFailed $event
     * @param array $additionalData
     * @return void
     */
    protected function registerType($event, string $type, array $additionalData = []) {
        return $this->register($event->task, array_merge([
            'type'       => $type,
            static::UUID => $this->uuid->get($event->task->mutexName()),
        ], $additionalData)) ;
    }

    /**
     * Set up the event listeners.
     *
     * @return void
     */
    public function listeners() {
        // For a starting task.
        Event::listen(ScheduledTaskStarting::class, function(ScheduledTaskStarting $event) {
            $this->registerType($event, static::TYPE_STARTED) ;
        }) ;

        // For a finished task.
        Event::listen(ScheduledTaskFinished::class, function(ScheduledTaskFinished $event) {
            $this->registerType($event, static::TYPE_FINISHED, ['runtime' => $event->runtime]) ;
        }) ;

        // For a failed task.
        Event::listen(ScheduledTaskFailed::class, function(ScheduledTaskFailed $event) {
            $this->registerType($event, static::TYPE_FAILED, ['exception' => $event->exception]) ;
            $this->uuid->remove($event->task->mutexName()) ;
        }) ;
    }   
}

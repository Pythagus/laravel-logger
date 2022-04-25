<?php

namespace Pythagus\LaravelLogger\Loggers;

use Illuminate\Support\Facades\Event;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

/**
 * Class JobLogger
 * @package Pythagus\LaravelLogger\Loggers
 *
 * @author: Damien MOLINA
 */
class JobLogger extends AbstractLogger {

    /**
     * Convert the given processing event to an array.
     *
     * @param JobProcessing $event
     */
    public static function objectToArray($event): array {
        return [
            'connection' => $event->connectionName,
            'queue'      => $event->job->getQueue(),
            'job'        => [
                'id'       => $event->job->getJobId(),
                'name'     => $event->job->getName(),
                'payload'  => $event->job->payload(),
                'attempts' => $event->job->attempts(),
            ],
        ] ;
    }

    /**
     * Get the job failing logger closure.
     *
     * @return void
     */
    public function listenFailingJobs() {
        Event::failing(function(JobFailed $event) {
            $this->register($event, ExceptionLogger::objectToArray($event->exception)) ;
        }) ;
    }

    /**
     * Listen the processing jobs. This event is
     * generated before executing the job.
     *
     * @return void
     */
    public function listenProcessingJobs() {
        Event::listen(function(JobProcessing $event) {
            $this->register($event) ;
        }) ;
    }

    /**
     * Listen the processing jobs. This event is
     * generated before executing the job.
     *
     * @return void
     */
    public function listenProcessedJobs() {
        Event::listen(function(JobProcessed $event) {
            $this->register($event) ;
        });
    }
}

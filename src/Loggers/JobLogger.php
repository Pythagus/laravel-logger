<?php

namespace Pythagus\LaravelLogger\Loggers;

use Pythagus\LaravelLogger\Logger;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
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
        return array_merge([
            'connection' => $event->connectionName,
            'status'     => 'processing'
        ], static::getJobData($event->job)) ;
    }

    /**
     * Get the job data.
     * 
     * @return array
     */
    protected static function getJobData(Job $job) {
        return [
            'queue' => $job->getQueue(),
            'job'   => [
                'id'       => $job->getJobId(),
                'name'     => $job->getName(),
                'payload'  => $job->payload(),
                'attempts' => $job->attempts(),
            ]
        ] ;
    }

    /**œ
     * Get the job failing logger closure.
     *
     * @return void
     */
    public function listenFailingJobs() {
        Queue::failing(function(JobFailed $event) {
            Logger::error()->register($event->exception, array_merge([
                'connection' => $event->connectionName,
                'status'     => 'failed',
            ], static::getJobData($event->job))) ;
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
}

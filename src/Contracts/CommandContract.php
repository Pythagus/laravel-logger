<?php

namespace Pythagus\LaravelLogger\Contracts;

/**
 * Command logger contract.
 * 
 * @author Damien MOLINA
 */
interface CommandContract {

    /**
     * Log type for a started command.
     * 
     * @var int
     */
    public const TYPE_STARTED = 'started' ;

    /**
     * Log type for a finished command.
     * 
     * @var int
     */
    public const TYPE_FINISHED = 'finished' ;

    /**
     * Log type for a failed command.
     * 
     * @var int
     */
    public const TYPE_FAILED = 'failed' ;

}
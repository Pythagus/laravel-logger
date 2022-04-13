<?php

namespace Pythagus\LaravelLogger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class LydiaLog
 * @package Pythagus\LaravelLydia\Support
 *
 * @property string file
 *
 * @author: Damien MOLINA
 */
class FileLogger extends Logger {

    /**
     * Log file name.
     *
     * @var string
     */
    private $file ;

    /**
     * Make a specific Lydia log manager.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct('logger') ;

        $this->setFileName() ;
        $this->pushHandler(new StreamHandler(
            $this->getFilePath(), Logger::WARNING
        )) ;
    }

    /**
     * Get the file name regarding the
     * current date.
     *
     * @return void
     */
    private function setFileName() {
        $date = date('Y-m-d') ;

        $this->file = "logger-$date.log" ;
    }

    /**
     * Get the file path.
     *
     * @return string
     */
    public function getFilePath() {
        return storage_path('logs/logger/' . $this->file) ;
    }

    /**
     * Report the given throwable.
     *
     * @param Throwable $throwable
     */
    public static function report($throwable) {
        $logger = new static();
        $logger->alert(
                json_encode($throwable) ?? "tata"
        );
    }
}
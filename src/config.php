<?php 

return [

    /*
    |------------------------------------------
    | Forgotten field with security sensibility.
    |------------------------------------------
    |
    | Sensible fields that are removed from the logs.
    */
    'except' => [
        'password',
        'remember_token',
    ],

    /*
    |------------------------------------------
    | Main website key.
    |------------------------------------------
    |
    | This key is mainly used to send logs from your
    | website to the logging server.
    */
    'key' => (string) env('LOGGER_KEY'),

    /*
    |------------------------------------------
    | Main website URL.
    |------------------------------------------
    |
    | This is the URL of the website the logs will
    | be sent to. You can choose whatever server you
    | want.
    */
    'url' => (string) env('LOGGER_URL'),
] ;
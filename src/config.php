<?php 

return [

    /*
    | ------------------------------------------
    | Forgotten field with security sensibility.
    | ------------------------------------------
    |
    | Sensible fields that are removed from the logs.
     */
    'except' => [
        'password',
        'remember_token',
    ],
] ;
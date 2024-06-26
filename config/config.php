<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Time
    |--------------------------------------------------------------------------
    |
    | Cache time for get data comment
    |
    | - set zero for remove cache
    | - set null for forever
    |
    | - unit: minutes
    */

    "cache_time" => env("COMMENT_CACHE_TIME", 0),

    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | Table name in database
    */

    "tables" => [
        'comment' => 'comments',
        'user' => 'users'
    ],

];

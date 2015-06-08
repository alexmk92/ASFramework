<?php

/*
|--------------------------------------------------------------------------
| Config.php
|--------------------------------------------------------------------------
|
| This is a private configuration file to define application wide constants,
| it should be .gitignore to prevent people from discovering configuration
| details for sensitive data.
|
*/

define(DB_HOST, 'localhost');
define(DB_NAME, 'your_db');
define(DB_USER, 'root');
define(DB_PASS, '');

/*
|--------------------------------------------------------------------------
| Test constants
|--------------------------------------------------------------------------
|
| Tests the value of the constant, if its null or empty then return a
| default value specified by the client.
|
*/

function conf($x, $out)
{
    if (!isset($x) || empty($x))
    {
        return $out;
    }
    return $x;
}
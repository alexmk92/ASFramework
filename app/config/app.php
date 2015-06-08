<?php
return
    [
        /*
        |--------------------------------------------------------------------------
        | Application Debugging
        |--------------------------------------------------------------------------
        |
        | When true, this will enable PHP to write error messages back to the
        | client.  This should only be used in production, and never in
        | release.
        |
        */

        'debug' => true,

        /*
        |--------------------------------------------------------------------------
        | Database Host IP
        |--------------------------------------------------------------------------
        |
        | The IP to which the host resides.  This will be used to connect to
        | the database so that information can be stored.
        |
        */

        'db_host' => conf(DB_HOST, 'localhost'),

        /*
        |--------------------------------------------------------------------------
        | Database Name
        |--------------------------------------------------------------------------
        |
        | The name of the Database that the application should connect to
        |
        */

        'db_name' => conf(DB_NAME, 'unset'),

        /*
        |--------------------------------------------------------------------------
        | Database Username
        |--------------------------------------------------------------------------
        |
        | The username required to log into the database
        |
        */
        'db_user'  => conf(DB_USER, 'root'),
        /*
        |--------------------------------------------------------------------------
        | Database Password
        |--------------------------------------------------------------------------
        |
        | The password required to log into the database
        |
        */

        'db_pass'  => conf(DB_PASS, 'unset'),

        /*
        |--------------------------------------------------------------------------
        | PDO Style
        |--------------------------------------------------------------------------
        |
        | Sets the default fetch style for the PDO client, it can be fine tuned
        | later in the application, but for now we will always fetch ASSOC
        | arrays from the client.
        |
        */

        'fetch' => PDO::FETCH_ASSOC,
    ];
<?php
//echo "ENV IS \n\n;";
//vaR_dump(env());
//die();
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'server' => ['server_name' => env('CLOUD_MQTT_SERVER'),
        'username' => env('CLOUD_MQTT_USERNAME'),
        'password' => env('CLOUD_MQTT_PASSWORD'),
        'port' => env('CLOUD_MQTT_PORT'),
        'key' => env('CLOUD_MQTT_KEY'),
        'prefix' => env('CLOUD_MQTT_PREFIX')
    ],

];

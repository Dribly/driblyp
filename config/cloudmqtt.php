<?php

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

    'server' => ['server_name' => getenv('CLOUD_MQTT_SERVER'),
        'username' => getenv('CLOUD_MQTT_USERNAME'),
        'password' => getenv('CLOUD_MQTT_PASSWORD'),
        'port' => getenv('CLOUD_MQTT_PORT'),
        'key' => getenv('CLOUD_MQTT_KEY'),
        'prefix' => getenv('CLOUD_MQTT_PREFIX')
    ],

];

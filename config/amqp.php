<?php

return [
    'host' => env('AMQP_HOST', 'localhost'),
    'port' => env('AMQP_PORT', '5671'),
    'user' => env('AMQP_USER', 'guest'),
    'password' => env('AMQP_PASSWORD', 'guest'),
];

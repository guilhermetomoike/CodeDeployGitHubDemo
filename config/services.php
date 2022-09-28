<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'number' => env('TWILIO_NUMBER'),
    ],

    'iugu' => [
        'token' => env('IUGU_TOKEN'),
        'webhook_token' => env('IUGU_WEBHOOK_TOKEN'),
        'multa' => 2,
        'juros' => 1,
    ],
    'asas' => [
        'token' => env('ASAS_TOKEN'),
        
        // 'webhook_token' => env('IUGU_WEBHOOK_TOKEN'),
        'multa' => 2,
        'juros' => 1,
    ],
    'linker' =>[
        'token'=>env('LINKER_TOKEN')
    ],

    'plugnotas' => [
        'token' => env('API_KEY_PLUGNOTAS'),
    ],

    'clicksign' => [
        'token' => env('API_CLICKSIGN_TOKEN'),
        'webhook_secret' => env('API_CLICKSIGN_WEBHOOK_SECRET'),
    ],

    'textract' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'version' => '2018-06-27',
    ],

    'slack' => [
        'token' => env('SLACK_TOKEN')
    ],

    'cpf-cnpj' => [
        'url' => env('CPF_CNPJ_URL'),
        'token' => env('CPF_CNPJ_TOKEN'),
        'cpf_package' => env('CPF_PACKAGE'),
        'cnpj_package' => env('CNPJ_PACKAGE')
    ],

    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY')
    ],

    'ploomes' => [
        'url' => env('PLOOMES_URL'),
        'key' => env('PLOOMES_KEY'),
    ],
];

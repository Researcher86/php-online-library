<?php

return [
    'use' => 'production',
    'properties' => [
        'production' => [
            'host'                => env('RABBIT_HOST'),
            'port'                => env('RABBIT_PORT'),
            'username'            => env('RABBIT_LOGIN'),
            'password'            => env('RABBIT_PASSWORD'),
            'vhost'               => env('RABBIT_VHOST'),
            'exchange'            => 'books',
            'exchange_type'       => 'topic',
            'consumer_tag'        => 'consumer',
            'ssl_options'         => [], // See https://secure.php.net/manual/en/context.ssl.php
            'connect_options'     => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
            'queue_properties'    => ['x-ha-policy' => ['S', 'all']],
            'exchange_properties' => [],
            'timeout'             => 0
        ],

    ],

];

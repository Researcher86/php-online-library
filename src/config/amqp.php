<?php

return [
    'connection' => [
        'host' => env('RABBIT_HOST'),
        'vhost' => env('RABBIT_VHOST'),
        'port' => env('RABBIT_PORT'),
        'login' => env('RABBIT_LOGIN'),
        'password' => env('RABBIT_PASSWORD'),
        'exchange' => 'library',
        'exchange_type' => AMQP_EX_TYPE_TOPIC,
        'consumer_tag' => 'consumer',
        'ssl_options' => [], // See https://secure.php.net/manual/en/context.ssl.php
        'connect_options' => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
        'queue_properties' => ['x-ha-policy' => ['S', 'all']],
        'exchange_properties' => [],
        'timeout' => 0
    ]
];

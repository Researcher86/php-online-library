<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('SQS_KEY', 'your-public-key'),
            'secret' => env('SQS_SECRET', 'your-secret-key'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'your-queue-name'),
            'region' => env('SQS_REGION', 'us-east-1'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],

        'amqp' => [
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
            'timeout' => 0,

            'queues' => [
                'process' => [
                    'book' => [
                        'name' => 'book',
                        'routing_key' => 'process.book.upload'
                    ]
                ],
                'notifications' => [
                    'email' => [
                        'name' => 'email',
                        'routing_key' => 'notification.email'
                    ],
                    'sms' => [
                        'name' => 'sms',
                        'routing_key' => 'notification.sms'
                    ],
                ],
            ]
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];

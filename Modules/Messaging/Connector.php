<?php

namespace Modules\Messaging;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connector
{
    private static AbstractConnection $connection;

    private function __construct() {}

    public static function getConnection(): AbstractConnection
    {
        if (!isset(self::$connection)) {
            self::$connection = new AMQPStreamConnection(
                config('amqp.host'),
                config('amqp.port'),
                config('amqp.user'),
                config('amqp.password')
            );
        }

        return self::$connection;
    }
}

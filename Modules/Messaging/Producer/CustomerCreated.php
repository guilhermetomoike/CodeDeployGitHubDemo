<?php

namespace Modules\Messaging\Producer;

use Modules\Messaging\Port\In\ICustomerCreated;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class CustomerCreated implements ICustomerCreated
{
    private AbstractConnection $connection;
    private string $exchange = 'customer.created';

    public function __construct(AbstractConnection $connection)
    {
        $this->connection = $connection;
    }

    public function dispatch(array $data): void
    {
        $message = new AMQPMessage(json_encode($data));
        $channel = $this->connection->channel();
        $channel->exchange_declare($this->exchange, AMQPExchangeType::FANOUT, false, false, false);
        $channel->basic_publish($message, $this->exchange);

        $channel->close();
    }
}

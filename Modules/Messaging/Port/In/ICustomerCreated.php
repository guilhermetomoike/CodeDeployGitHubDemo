<?php

namespace Modules\Messaging\Port\In;

interface ICustomerCreated
{
    public function dispatch(array $data): void;
}

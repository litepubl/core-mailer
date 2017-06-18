<?php

namespace LitePubl\Core\Mailer\Exception;

class ConnectError extends Exception
{
    const FORMAT_MESSAGE = 'Error connect to "%s" host';

    public function __construct(string $host)
    {
        parent::__construct(sprintf(static::FORMAT_MESSAGE, $host));
    }
}

<?php

namespace LitePubl\Core\Mailer\Exception;

class AuthException extends Exception
{
    const FORMAT_MESSAGE = 'Error Authenticate with login %s';

    public function __construct(string $login)
    {
        parent::__construct(sprintf(static::FORMAT_MESSAGE, $login));
    }
}

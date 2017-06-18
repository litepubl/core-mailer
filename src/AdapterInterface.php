<?php

namespace LitePubl\Core\Mailer;

interface AdapterInterface
{
    public function send(MessageInterface ... $messages);
}

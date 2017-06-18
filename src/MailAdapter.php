<?php

namespace LitePubl\Core\Mailer;

class MailAdapter implements AdapterInterface
{
    public function send(MessageInterface ... $messages)
    {
        foreach ($messages as $message) {
                \mail($message->getTo(), $message->getSubject(), $message->getBody(), $message->getHeaders());
        }
    }
}

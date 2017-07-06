<?php

namespace LitePubl\Core\Mailer;

interface MailerInterface
{
    public function send(MessageInterface ... $messages);
    public function newMessage(): MessageInterface;
    public function createMessage(string $toName, string $toEmail, string $subject, string $body): MessageInterface;
    public function sendToAdmin(string $subject, string $body);
}

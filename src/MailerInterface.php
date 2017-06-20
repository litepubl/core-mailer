<?php

namespace LitePubl\Core\Mailer;

interface MailerInterface
{
    public function send(MessageInterface ... $messages);
    public function createMessage(string $fromName, string $fromEmail, string $toName, string $toEmail, string $subject, string $body): MessageInterface;
    public function sendToAdmin(string $subject, string $body);
}

<?php

namespace LitePubl\Core\Mailer;

class Mailer implements MailerInterface
{
    protected $adapter;
    protected $adminEmail;
    protected $fromEamil;

    public function __construct(AdapterInterface $adapter, string $fromEmail, string $adminEmail)
    {
        $this->adapter = $adapter;
        $this->fromEmail = $fromEmail;
        $this->adminEmail = $adminEmail;
    }

    public function send(MessageInterface ... $messages)
    {
           $this->adapter->send($messages);
    }

    public function newMessage(): MessageInterface
    {
        return new Message();
    }

    public function createMessage(string $fromName, string $fromEmail, string $toName, string $toEmail, string $subject, string $body): MessageInterface
    {
        $message = $this->newMessage();
        $message->setFrom($fromName, $fromEmail);
        $message->setTo($toName, $toEmail);
        $message->setSubject($subject);
        $message->setBody($body);
        return $message;
    }

    public function sendToAdmin(string $subject, string $body)
    {
        $message = $this->createMessage('LitePubl', $this->fromEamil, 'Admin', $this->adminEmail, $subject, $body);
        $this->send($message);
    }
}

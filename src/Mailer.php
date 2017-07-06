<?php

namespace LitePubl\Core\Mailer;

class Mailer implements MailerInterface
{
    protected $adapter;
    protected $fromName;
    protected $fromEmail;
    protected $adminName;
    protected $adminEmail;

    public function __construct(AdapterInterface $adapter, string $fromName, string $fromEmail, string $adminName, string $adminEmail)
    {
        $this->adapter = $adapter;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->adminName = $adminName;
        $this->adminEmail = $adminEmail;
    }

    public function send(MessageInterface ... $messages)
    {
           $this->adapter->send($messages);
    }

    public function newMessage(): MessageInterface
    {
        $result = new Message();
        $result->setFrom($this->fromName, $this->fromEmail);
        return $result;
    }

    public function createMessage(string $toName, string $toEmail, string $subject, string $body): MessageInterface
    {
        $message = $this->newMessage();
        $message->setTo($toName, $toEmail);
        $message->setSubject($subject);
        $message->setBody($body);
        return $message;
    }

    public function sendToAdmin(string $subject, string $body)
    {
        $message = $this->createMessage($this->adminName, $this->adminEmail, $subject, $body);
        $this->send($message);
    }
}

<?php

namespace LitePubl\Core\Mailer;

use LitePubl\Core\Mailer\Exception\Exception;
use LitePubl\Core\LogManager\LogManagerInterface;

class Mailer implements MailerInterface
{
    protected $adapter;
    protected $logManager;
    private $hold;

    public function __construct(AdapterInterface $adapter, LogManagerInterface $logManager)
    {
        $this->adapter = $adapter;
        $this->logManager = $logManager;
        $this->hold = [];
    }

    public function send(MessageInterface ... $messages)
    {
        try {
            $this->adapter->send($messages);
        } catch (Exception $e) {
            $this->logManager->logException($e);
        }
    }
}

<?php

namespace LitePubl\Core\Mailer;

use LitePubl\Core\Mailer\Exception\ConnectError;
use LitePubl\Core\Mailer\Exception\AuthException;
use \SMTP;

class SmtpAdapter implements AdapterInterface
{
    const HELLO = 'localhost.localdomain';
    protected $smtp;
    protected $account;

    public function __construct(SMTP $smtp, array $account)
    {
        $this->smtp = $smtp;
        $this->account = $account;
    }

    protected function open()
    {
        $account = $this->account;
        if (!$this->smtp->Connect($account['host'], $account['port'], $account['timeout'])) {
            throw new ConnectError($account['host']);
        }

            $this->smtp->Hello($_SERVER['SERVER_NAME'] ?? static::HELLO);
        if (!$this->smtp->Authenticate($account['login'], $account['password'])) {
            throw new AuthException($account['login']);
        }
    }

    protected function close()
    {
            $this->smtp->Quit();
            $this->smtp->Close();
    }

    public function send(MessageInterface ... $messages)
    {
        $this->open();

        try {
            foreach ($messages as $message) {
                if ($this->smtp->Mail($this->account['login']) && $this->smtp->Recipient($message->getToEmail())) {
                    $message->setHeader('Subject', $message->getSubject());
                    $this->smtp->data($message->getHeaders() . "\n\n" . $message->getBody());
                }
            }
        } finally {
                $this->smtp->close();
        }
    }
}

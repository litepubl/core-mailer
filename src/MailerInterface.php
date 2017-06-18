<?php

namespace LitePubl\Core\Mailer;

interface MailerInterface
{
    public function send(MessageInterface ... $messages);
    public function newMessage(string $from, string $to, string $subj, string $body): MessageInterface;
    public function newsend($fromname, $fromemail, $toname, $toemail, $subj, $body);
    public function sendToAdmin(string $subject, string $body);
}

<?php

namespace LitePubl\Core\Mailer;

interface MessageInterface
{
    public function getSubject(): string;
    public function setSubject(string $subject);
    public function getBody(): string;
    public function setBody(string $body);
    public function getHeaders(): string;
    public function setHeaders(array $headers);
    public function getHeader(string $name): string;
    public function setHeader(string $name, string $value);
    public function getFrom(): string;
    public function setFrom(string $from);
    public function getTo(): string;
    public function setTo(string $to);
    public function getToEmail(): string;
    public function getEmail(string $name, string $email): string;
    public function addFile(string $fileName, string $fileContent);
}

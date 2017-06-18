<?php

namespace LitePubl\Core\Mailer;

class Message implements messageInterface
{
    protected $body = '';
    protected $subject = '';
    protected $toEmail = '';
    protected $headers;
    protected $boundary;

    public function __construct()
    {
        $this->headers = [
        'To' => '',
        'From' => '',
        'Reply-To' => '',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Transfer-Encoding' => '8bit',
        'Date' => date('r'),
        'X-Priority' => '3',
        'X-Mailer' => 'LitePubl Mailer'
        ];
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject ? sprintf('=?utf-8?B%s?=', base64_encode($subject)) : '';
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function getHeaders(): string
    {
        return $this->joinHeaders($this->headers);
    }

    protected function joinHeaders(array $headers): string
    {
        $a = [];
        foreach ($headers as $name => $value) {
            $a[] = sprintf('%s: %s', $name, $value);
        }

        return implode("\n", $a);
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function getHeader(string $name): string
    {
        return $this->headers[$name] ?? '';
    }

    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
    }

    public function getFrom(): string
    {
        return $this->headers['From'];
    }

    public function setFrom(string $name, string $email)
    {
        $from = $this->getEmail($name, $email);
        $this->headers['From'] = $from;
        $this->headers['Reply-To'] = $from;
    }

    public function getTo(): string
    {
        return $this->headers['To'];
    }

    public function setTo(string $name, string $email)
    {
        $this->headers['To'] = $this->getEmail($name, $email);
        $this->toEmail = $email;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function getEmail(string $name, string $email): string
    {
        if (empty($name)) {
            return $email;
        }

        return sprintf('=?utf-8?B?%s?= <%s>', base64_encode($name), $email);
    }

    public function addFile(string $fileName, string $fileContent)
    {
        if (!$this->boundary) {
                $this->boundary = md5(microtime());
            $this->headers['MIME-Version'] = '1.0';
            $this->headers['Content-Type'] = sprintf('multipart/mixed; boundary="%s"', $this->boundary);

                $headers = [
            'Content-Type' => $this->headers['Content-Type'],
            'Content-Transfer-Encoding' => 'base64',
                ];

                $this->body = sprintf("--%s\n%s\n\n%s\n\n", $this->boundary, $this->joinHeaders($headers), base64_encode($this->body));
        }

        $headers = [
        'Content-Type' => sprintf('application/octet-stream; name="%s"', $fileName),
        'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
        'Content-Transfer-Encoding' => 'base64',
        ];

        $this->body = sprintf("--%s\n%s\n\n%s\n\n", $this->boundary, $this->joinHeaders($headers), base64_encode($fileContent));
    }
}

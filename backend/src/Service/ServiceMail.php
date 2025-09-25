<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class ServiceMail
{
    private MailerInterface $mailer;
    private string $from;

    public function __construct(MailerInterface $mailer, string $from = 'girlspower434@gmail.com')
    {
        $this->mailer = $mailer;
        $this->from = $from;
    }

    public function sendEmail(string $to, string $subject, string $content, bool $isHtml = false): void
    {
        $email = (new Email())
            ->from(new Address($this->from, 'Mon App'))
            ->to($to)
            ->subject($subject);

        if ($isHtml) {
            $email->html($content);
        } else {
            $email->text($content);
        }

        $this->mailer->send($email);
    }
}

<?php

namespace Fernando\Mailsender;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class Sender
{
    private Mailer $mailer;

    public function __construct()
    {
        $dotenv = new Dotenv();

        $smtpserver = $dotenv->get('SMTP_HOST');

        $transport = Transport::fromDsn($smtpserver);

        $this->mailer = new Mailer($transport);
    }

    public function send(Email $email)
    {
        $this->mailer->send($email);
    }
}
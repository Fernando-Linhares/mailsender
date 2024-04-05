<?php

namespace Fernando\Mailsender;

use Symfony\Component\Mime\Email;

class EmailTask extends Task implements TaskInterface
{
    public function __construct(
        private Email $email,
        private int $delay = 0
    ){}

    public function handle(): void
    {
        if($this->delay)
            sleep($this->delay);

        $sender = new Sender;

        $sender->send($this->email);
    }
}
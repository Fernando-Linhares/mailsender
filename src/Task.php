<?php

namespace Fernando\Mailsender;

class Task implements TaskInterface
{
    public function handle(): void
    {
        //
    }

    public function serialize(): string
    {
        return serialize($this);
    }
}
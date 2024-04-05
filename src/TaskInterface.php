<?php

namespace Fernando\Mailsender;

interface TaskInterface
{
    public function handle(): void;

    public function serialize(): string;
}
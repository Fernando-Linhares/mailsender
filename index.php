<?php

require_once 'vendor/autoload.php';

use Fernando\Mailsender\{ Queue, EmailTask };
use Symfony\Component\Mime\Email;
// 172.20.0.2
$queue = new Queue("172.23.0.2");

$email1 = new Email();
$email2 = new Email();
$email3 = new Email();

$email1 = $email1->from("hello1@example.com")
->to("you@example.com")
->subject(' 1 - Time for Symfony Mailer!')
->text('Sending emails is fun again!')
->html('<p>See Twig integration for better HTML integration!</p>');

$email2 = $email2->from("hello2@example.com")
->to("you@example.com")
->subject(' 2 - Time for Symfony Mailer!')
->text('Sending emails is fun again!')
->html('<p>See Twig integration for better HTML integration!</p>');

$email3 = $email3->from("hello3@example.com")
->to("you@example.com")
->subject(' 3 - Time for Symfony Mailer!')
->text('Sending emails is fun again!')
->html('<p>See Twig integration for better HTML integration!</p>');

$emailTask1 = new EmailTask($email1);
$queue->dispatch($emailTask1);

$emailTask2 = new EmailTask($email2);
$queue->dispatch($emailTask2);

$emailTask3 = new EmailTask($email3);
$queue->dispatch($emailTask3);
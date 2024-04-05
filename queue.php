<?php

require_once 'vendor/autoload.php';

use Fernando\Mailsender\{ Queue, Dotenv };

$dotenv = new Dotenv();

$queue = new Queue($dotenv->get('RABBIT_HOST'));

$queue->work();
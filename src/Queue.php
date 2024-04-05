<?php

namespace Fernando\Mailsender;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class Queue
{
    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;

    private string $queue_name;

    private Dotenv $dotenv;

    public function __construct($host=null, $queue_name='default')
    {
        $this->dotenv = new Dotenv();

        $connection = new AMQPStreamConnection($host ?? $this->dotenv->get('RABBIT_HOST'), 5672, 'guest', 'guest');

        $this->connection = $connection;

        $this->channel = $this->connection->channel();

        $this->queue_name = $queue_name;
    }

    public function work(): void
    {
        try
        {
            $this->channel->queue_declare($this->queue_name, false, true, false, false);

            $callback = static function($message) {

                $task = unserialize($message->body);

                $init = strtotime('now');

                $taskName = get_class($task);

                $task->handle();

                $time = strtotime('now');

                $timespend = $time - $init;

                echo "..............................................\n";
                echo "#  [x] Task Dispatched {$taskName} in {$time} \n";
                echo "#  [:] Time spend - {$timespend} \n";
                echo "..............................................\n";
            };

            $this->channel->basic_consume($this->queue_name, '', false, true, false, false, $callback);

            $msg = $this->message("[*] Queue Working... [*]");

            $this->channel->basic_publish($msg);

            $this->channel->consume();
        }
        catch (\Throwable $exception)
        {
            echo $exception->getMessage();
        }
    }
    
    public function dispatch(TaskInterface $task)
    {
        $message = $this->message($task->serialize());

        $this->channel->basic_publish($message, '', $this->queue_name);

        $classname = get_class($task);

        $time = strtotime('now');

        echo "[x] Task {$classname} Dispatched in {$time}\n";
    }

    private function message($content)
    {
        return new AMQPMessage($content);
    }

    public function __destruct()
    {
        $this->connection->close();

        $this->channel->close();
    }
}
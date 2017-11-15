<?php

namespace Freyo\LaravelQueueCMQ\Queue\Jobs;

use Freyo\LaravelQueueCMQ\Queue\CMQQueue;
use Freyo\LaravelQueueCMQ\Queue\Driver\Message;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Database\DetectsDeadlocks;
use Illuminate\Queue\Jobs\Job;

class CMQJob extends Job implements JobContract
{
    use DetectsDeadlocks;

    protected $connection;
    protected $message;

    public function __construct(Container $container, CMQQueue $connection, Message $message)
    {
        $this->container  = $container;
        $this->connection = $connection;
        $this->message    = $message;
    }

    /**
     * Get the raw body of the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->message->msgBody;
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return $this->message->dequeueCount;
    }
}
<?php

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

if (!interface_exists('QueuedJob')) {
    return;
}

/**
 * Handler for logging events into QueuedJob message data
 */
class QueuedJobLogHandler extends AbstractProcessingHandler
{
    /**
     * Job to log to
     *
     * @var QueuedJob
     */
    protected $queuedJob;

    /**
     * @param QueuedJob $queuedJob Job to log to
     * @param integer $level  The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(QueuedJob $queuedJob, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->setQueuedJob($queuedJob);
    }

    /**
     * Set a new queuedjob
     *
     * @param QueuedJob $queuedJob
     */
    public function setQueuedJob(QueuedJob $queuedJob)
    {
        $this->queuedJob = $queuedJob;
    }

    /**
     * Get queuedjob
     *
     * @return QueuedJob
     */
    public function getQueuedJob()
    {
        return $this->queuedJob;
    }

    protected function write(array $record)
    {
        // Write formatted message
        $this->getQueuedJob()->addMessage($record['formatted']);
    }
}

<?php

namespace MyCLabs\Work\Dispatcher;

use MyCLabs\Work\Task\Task;
use MyCLabs\Work\Worker\SimpleWorker;

/**
 * Simple implementation not using any work queue: tasks are executed right away in the same process.
 *
 * @see SimpleWorker
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class SimpleWorkDispatcher extends WorkDispatcher
{
    /**
     * @var SimpleWorker
     */
    private $worker;

    /**
     * The SimpleWorkDispatcher executes task synchronously, so it needs to know the
     * worker to be able to call it directly.
     *
     * @param SimpleWorker $simpleWorker
     */
    public function __construct(SimpleWorker $simpleWorker)
    {
        $this->worker = $simpleWorker;
    }

    /**
     * {@inheritdoc}
     * @return mixed This particular implementation can return the result since it's executed synchronously
     */
    public function runBackground(Task $task)
    {
        // Event: before dispatching the task
        $this->triggerEvent(self::EVENT_BEFORE_TASK_DISPATCHED, [$task]);

        return $this->worker->executeTask($task);
    }
}

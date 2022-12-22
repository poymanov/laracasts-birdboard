<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskNotBelongsToProject extends Exception
{
    public function __construct(string $taskId, string $projectId)
    {
        $message = "Task $taskId not belongs to project $projectId";

        parent::__construct($message);
    }
}

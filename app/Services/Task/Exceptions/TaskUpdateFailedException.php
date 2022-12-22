<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskUpdateFailedException extends Exception
{
    public function __construct(string $id)
    {
        $message = 'Failed to update task: ' . $id;

        parent::__construct($message);
    }
}

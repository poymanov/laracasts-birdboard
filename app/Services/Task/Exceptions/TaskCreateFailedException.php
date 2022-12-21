<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create task';

        parent::__construct($message);
    }
}

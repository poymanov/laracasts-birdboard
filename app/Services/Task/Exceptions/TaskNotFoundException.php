<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskNotFoundException extends Exception
{
    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $message = 'Project not found: ' . $id;

        parent::__construct($message);
    }
}

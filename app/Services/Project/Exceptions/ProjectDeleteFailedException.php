<?php

namespace App\Services\Project\Exceptions;

use Exception;

class ProjectDeleteFailedException extends Exception
{
    public function __construct(string $id)
    {
        $message = 'Failed to delete project: ' . $id;

        parent::__construct($message);
    }
}

<?php

namespace App\Services\Project\Exceptions;

use Exception;

class ProjectCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create project';

        parent::__construct($message);
    }
}

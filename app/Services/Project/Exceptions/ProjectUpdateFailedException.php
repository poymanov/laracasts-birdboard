<?php

namespace App\Services\Project\Exceptions;

use Exception;

class ProjectUpdateFailedException extends Exception
{
    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $message = 'Failed to update project: ' . $id;

        parent::__construct($message);
    }
}

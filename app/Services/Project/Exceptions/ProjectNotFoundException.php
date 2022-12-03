<?php

namespace App\Services\Project\Exceptions;

use Exception;

class ProjectNotFoundException extends Exception
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

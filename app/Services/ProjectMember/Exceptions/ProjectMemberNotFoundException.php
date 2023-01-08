<?php

namespace App\Services\ProjectMember\Exceptions;

use Exception;

class ProjectMemberNotFoundException extends Exception
{
    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $message = 'Project member not found: ' . $id;

        parent::__construct($message);
    }
}

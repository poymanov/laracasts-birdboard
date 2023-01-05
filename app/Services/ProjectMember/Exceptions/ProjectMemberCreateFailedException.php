<?php

namespace App\Services\ProjectMember\Exceptions;

use Exception;

class ProjectMemberCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create project member';

        parent::__construct($message);
    }
}

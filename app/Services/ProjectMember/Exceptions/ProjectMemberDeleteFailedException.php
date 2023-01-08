<?php

namespace App\Services\ProjectMember\Exceptions;

use Exception;

class ProjectMemberDeleteFailedException extends Exception
{
    public function __construct(string $id)
    {
        $message = 'Failed to delete project member: ' . $id;

        parent::__construct($message);
    }
}

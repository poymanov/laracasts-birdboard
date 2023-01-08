<?php

namespace App\Services\ProjectMember\Exceptions;

use Exception;

class ProjectMemberWrongMemberException extends Exception
{
    public function __construct()
    {
        $message = 'This member is not a member of the project';

        parent::__construct($message);
    }
}

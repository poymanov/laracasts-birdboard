<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteAcceptAnotherUserException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to accept another user invite';

        parent::__construct($message);
    }
}

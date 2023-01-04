<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteRejectAnotherUserException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to reject another user invite';

        parent::__construct($message);
    }
}

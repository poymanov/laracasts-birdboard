<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteAcceptWrongStatusException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to accept invite in wrong status';

        parent::__construct($message);
    }
}

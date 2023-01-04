<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteRejectWrongStatusException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to reject invite in wrong status';

        parent::__construct($message);
    }
}

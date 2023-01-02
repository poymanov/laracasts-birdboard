<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create invite';

        parent::__construct($message);
    }
}

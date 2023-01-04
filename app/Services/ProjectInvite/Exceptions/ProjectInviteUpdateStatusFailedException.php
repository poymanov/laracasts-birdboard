<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteUpdateStatusFailedException extends Exception
{
    public function __construct(string $id)
    {
        $message = 'Failed to update status: ' . $id;

        parent::__construct($message);
    }
}

<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteSelfCreateException extends Exception
{
    public function __construct()
    {
        $message = 'Not possible invite owner to his project';

        parent::__construct($message);
    }
}

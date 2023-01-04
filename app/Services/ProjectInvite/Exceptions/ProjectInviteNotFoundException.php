<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;

class ProjectInviteNotFoundException extends Exception
{
    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $message = 'Project invite not found: ' . $id;

        parent::__construct($message);
    }
}

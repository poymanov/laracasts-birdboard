<?php

namespace App\Services\ProjectInvite\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

class ProjectInviteAlreadyException extends Exception
{
    public function __construct(Email $email)
    {
        $message = 'User already invited: ' . $email->value();

        parent::__construct($message);
    }
}

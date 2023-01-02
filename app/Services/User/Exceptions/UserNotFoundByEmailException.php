<?php

namespace App\Services\User\Exceptions;

use Exception;

class UserNotFoundByEmailException extends Exception
{
    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $message = 'User not found by email: ' . $email;

        parent::__construct($message);
    }
}

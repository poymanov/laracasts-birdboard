<?php

namespace App\Services\User\Exceptions;

use Exception;

class UserNotFoundByIdException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'User not found by id: ' . $id;

        parent::__construct($message);
    }
}

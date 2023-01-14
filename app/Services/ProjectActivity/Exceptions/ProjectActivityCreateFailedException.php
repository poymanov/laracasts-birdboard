<?php

namespace App\Services\ProjectActivity\Exceptions;

use Exception;

class ProjectActivityCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create project activity';

        parent::__construct($message);
    }
}

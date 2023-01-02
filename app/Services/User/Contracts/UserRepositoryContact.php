<?php

namespace App\Services\User\Contracts;

use App\Services\User\Dtos\UserDto;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

interface UserRepositoryContact
{
    /**
     * Получение DTO объекта по email
     *
     * @param Email $email
     *
     * @return UserDto
     * @throws UserNotFoundByEmailException
     */
    public function findByEmail(Email $email): UserDto;
}

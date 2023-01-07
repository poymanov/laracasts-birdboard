<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\Dtos\UserDto;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use App\Services\User\Exceptions\UserNotFoundByIdException;
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

    /**
     * Получение модели по ID
     *
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundByIdException
     */
    public function findModelById(int $id): User;
}

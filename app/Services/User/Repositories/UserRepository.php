<?php

namespace App\Services\User\Repositories;

use App\Models\User;
use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Contracts\UserRepositoryContact;
use App\Services\User\Dtos\UserDto;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

class UserRepository implements UserRepositoryContact
{
    public function __construct(private readonly UserDtoFactoryContract $userDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(Email $email): UserDto
    {
        return $this->userDtoFactory->createFromModel($this->findModelByEmail($email));
    }

    /**
     * Получение модели по email
     *
     * @param Email $email
     *
     * @return User
     * @throws UserNotFoundByEmailException
     */
    private function findModelByEmail(Email $email): User
    {
        $user = User::whereEmail($email->value())->first();

        if (!$user) {
            throw new UserNotFoundByEmailException($email->value());
        }

        return $user;
    }
}

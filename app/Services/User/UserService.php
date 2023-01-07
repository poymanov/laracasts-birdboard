<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContact;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Dtos\UserDto;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

class UserService implements UserServiceContract
{
    public function __construct(private readonly UserRepositoryContact $userRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(Email $email): UserDto
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * @inheritDoc
     */
    public function findModelById(int $id): User
    {
        return $this->userRepository->findModelById($id);
    }
}

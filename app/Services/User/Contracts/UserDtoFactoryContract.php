<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\Dtos\UserDto;

interface UserDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param User $user
     *
     * @return UserDto
     */
    public function createFromModel(User $user): UserDto;
}

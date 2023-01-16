<?php

namespace App\Services\User\Factories;

use App\Models\User;
use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Dtos\UserDto;

class UserDtoFactory implements UserDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(User $user): UserDto
    {
        $userDto              = new UserDto();
        $userDto->id          = $user->id;
        $userDto->email       = $user->email;
        $userDto->name        = $user->name;
        $userDto->gravatarUrl = $this->getGravatarUrl($user->email);

        return $userDto;
    }

    /**
     * Получение ссылки на аватар пользователя
     *
     * @param string $email
     *
     * @return string
     */
    private function getGravatarUrl(string $email): string
    {
        $hash = md5($email);

        return "https://gravatar.com/avatar/{$hash}?" . http_build_query(['s' => 60]);
    }
}

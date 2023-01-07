<?php

namespace App\Services\Notification\Contracts;

use App\Services\User\Exceptions\UserNotFoundByIdException;
use Illuminate\Notifications\Notification;

interface NotificationServiceContract
{
    /**
     * Отправка email-уведомления пользователю
     *
     * @param int          $userId
     * @param Notification $notification
     *
     * @return void
     * @throws UserNotFoundByIdException
     */
    public function mail(int $userId, Notification $notification): void;
}

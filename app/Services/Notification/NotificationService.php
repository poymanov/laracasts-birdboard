<?php

namespace App\Services\Notification;

use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Notifications\Notification;

class NotificationService implements NotificationServiceContract
{
    public function __construct(private readonly UserServiceContract $userService)
    {
    }

    /**
     * @inheritDoc
     */
    public function mail(int $userId, Notification $notification): void
    {
        $user = $this->userService->findModelById($userId);
        $user->notify($notification);
    }
}

<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectInviteRepositoryContract
{
    /**
     * Проверка: существует ли для пользователя приглашение в проект
     *
     * @param Uuid $projectId
     * @param int  $userId
     *
     * @return bool
     */
    public function isExistsByProjectIdAndUserId(Uuid $projectId, int $userId): bool;

    /**
     * Создание приглашения
     *
     * @param ProjectInviteCreateDto $inviteCreateDto
     *
     * @return void
     * @throws ProjectInviteCreateFailedException
     */
    public function create(ProjectInviteCreateDto $inviteCreateDto): void;
}

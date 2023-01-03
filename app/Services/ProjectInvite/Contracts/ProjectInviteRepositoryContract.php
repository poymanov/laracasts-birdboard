<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use Exception;
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

    /**
     * Получение приглашений пользователя по статусу
     *
     * @param int                     $userId
     * @param ProjectInviteStatusEnum $status
     *
     * @return ProjectInviteDto[]
     * @throws Exception
     */
    public function findAllByUserIdAndStatus(int $userId, ProjectInviteStatusEnum $status): array;
}

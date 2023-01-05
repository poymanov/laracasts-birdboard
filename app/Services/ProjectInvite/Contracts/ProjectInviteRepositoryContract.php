<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteNotFoundException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteUpdateStatusFailedException;
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
     * Получение приглашения по ID
     *
     * @param Uuid $id
     *
     * @return ProjectInviteDto
     * @throws ProjectInviteNotFoundException
     */
    public function findOneById(Uuid $id): ProjectInviteDto;

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

    /**
     * Изменение статуса
     *
     * @param Uuid                    $id
     * @param ProjectInviteStatusEnum $status
     *
     * @return void
     * @throws ProjectInviteNotFoundException
     * @throws ProjectInviteUpdateStatusFailedException
     */
    public function updateStatus(Uuid $id, ProjectInviteStatusEnum $status): void;

    /**
     * Является ли статус указанным
     *
     * @param Uuid                    $id
     * @param ProjectInviteStatusEnum $status
     *
     * @return bool
     */
    public function isStatus(Uuid $id, ProjectInviteStatusEnum $status): bool;

    /**
     * Принадлежит ли приглашение пользователю
     *
     * @param Uuid $id
     * @param int  $userId
     *
     * @return bool
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool;
}

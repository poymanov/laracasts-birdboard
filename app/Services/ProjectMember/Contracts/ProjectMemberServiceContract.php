<?php

namespace App\Services\ProjectMember\Contracts;

use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;
use App\Services\ProjectMember\Exceptions\ProjectMemberWrongMemberException;
use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectMemberServiceContract
{
    /**
     * Создание участника проекта
     *
     * @param ProjectMemberCreateDto $projectMemberCreateDto
     *
     * @return void
     * @throws ProjectMemberCreateFailedException
     */
    public function create(ProjectMemberCreateDto $projectMemberCreateDto): void;

    /**
     * Получение участников проекта
     *
     * @param Uuid $projectId
     *
     * @return ProjectMemberDto[]
     * @throws Exception
     */
    public function findAllByProjectId(Uuid $projectId): array;

    /**
     * Удаление участника проекта
     *
     * @param Uuid $projectId
     * @param Uuid $projectMemberId
     *
     * @return void
     * @throws ProjectMemberWrongMemberException
     * @throws ProjectNotFoundException
     */
    public function delete(Uuid $projectId, Uuid $projectMemberId): void;

    /**
     * Является ли пользователь участником проекта
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return bool
     */
    public function isProjectMember(int $userId, Uuid $projectId): bool;
}

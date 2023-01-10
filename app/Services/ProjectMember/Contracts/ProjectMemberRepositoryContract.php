<?php

namespace App\Services\ProjectMember\Contracts;

use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;
use App\Services\ProjectMember\Exceptions\ProjectMemberDeleteFailedException;
use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectMemberRepositoryContract
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
     * Получение участника проекта
     *
     * @param Uuid $id
     *
     * @return ProjectMemberDto
     */
    public function findOneById(Uuid $id): ProjectMemberDto;

    /**
     * Удаление участника проекта
     *
     * @param Uuid $id
     *
     * @return void
     * @throws ProjectMemberDeleteFailedException
     * @throws ProjectNotFoundException
     */
    public function delete(Uuid $id): void;

    /**
     *
     * Принадлежит ли запись об участнике проекту
     *
     * @param Uuid $id
     * @param Uuid $projectId
     *
     * @return bool
     */
    public function isBelongsToProject(Uuid $id, Uuid $projectId): bool;

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

<?php

namespace App\Services\ProjectMember\Contracts;

use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;
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
}

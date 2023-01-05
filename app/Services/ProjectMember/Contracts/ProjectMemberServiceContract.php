<?php

namespace App\Services\ProjectMember\Contracts;

use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;

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
}

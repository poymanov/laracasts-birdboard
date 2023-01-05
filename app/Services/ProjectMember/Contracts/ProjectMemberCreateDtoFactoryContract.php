<?php

namespace App\Services\ProjectMember\Contracts;

use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectMemberCreateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param int  $userId
     * @param Uuid $projectId
     * @param Uuid $inviteId
     *
     * @return ProjectMemberCreateDto
     */
    public function createFromParams(int $userId, Uuid $projectId, Uuid $inviteId): ProjectMemberCreateDto;
}

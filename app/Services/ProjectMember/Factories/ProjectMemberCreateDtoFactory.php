<?php

namespace App\Services\ProjectMember\Factories;

use App\Services\ProjectMember\Contracts\ProjectMemberCreateDtoFactoryContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectMemberCreateDtoFactory implements ProjectMemberCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(int $userId, Uuid $projectId, Uuid $inviteId): ProjectMemberCreateDto
    {
        $projectMemberCreateDto            = new ProjectMemberCreateDto();
        $projectMemberCreateDto->userId    = $userId;
        $projectMemberCreateDto->projectId = $projectId;
        $projectMemberCreateDto->inviteId  = $inviteId;

        return $projectMemberCreateDto;
    }
}

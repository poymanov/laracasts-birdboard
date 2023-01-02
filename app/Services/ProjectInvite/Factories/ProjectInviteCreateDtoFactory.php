<?php

namespace App\Services\ProjectInvite\Factories;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\ProjectInvite\Contracts\ProjectInviteCreateDtoFactoryContract;
use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectInviteCreateDtoFactory implements ProjectInviteCreateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param Uuid $projectId
     * @param int  $userId
     *
     * @return ProjectInviteCreateDto
     */
    public function createFromParams(Uuid $projectId, int $userId): ProjectInviteCreateDto
    {
        $inviteCreateDto            = new ProjectInviteCreateDto();
        $inviteCreateDto->projectId = $projectId;
        $inviteCreateDto->userId    = $userId;
        $inviteCreateDto->status    = ProjectInviteStatusEnum::SENT;

        return $inviteCreateDto;
    }
}

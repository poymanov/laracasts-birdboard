<?php

namespace App\Services\ProjectMember\Repositories;

use App\Models\ProjectMember;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;

class ProjectMemberRepository implements ProjectMemberRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ProjectMemberCreateDto $projectMemberCreateDto): void
    {
        $projectMember             = new ProjectMember();
        $projectMember->user_id    = $projectMemberCreateDto->userId;
        $projectMember->project_id = $projectMemberCreateDto->projectId->value();
        $projectMember->invite_id  = $projectMemberCreateDto->inviteId->value();

        if (!$projectMember->save()) {
            throw new ProjectMemberCreateFailedException();
        }
    }
}

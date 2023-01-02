<?php

namespace App\Services\ProjectInvite\Repositories;

use App\Models\ProjectInvite;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectInviteRepository implements ProjectInviteRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function isExistsByProjectIdAndUserId(Uuid $projectId, int $userId): bool
    {
        return ProjectInvite::where(['project_id' => $projectId->value(), 'user_id' => $userId])->exists();
    }

    /**
     * @inheritDoc
     */
    public function create(ProjectInviteCreateDto $inviteCreateDto): void
    {
        $projectInvite             = new ProjectInvite();
        $projectInvite->project_id = $inviteCreateDto->projectId->value();
        $projectInvite->user_id    = $inviteCreateDto->userId;
        $projectInvite->status     = $inviteCreateDto->status->value;

        if (!$projectInvite->save()) {
            throw new ProjectInviteCreateFailedException();
        }
    }
}

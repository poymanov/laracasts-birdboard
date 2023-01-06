<?php

namespace App\Services\ProjectMember\Repositories;

use App\Models\ProjectMember;
use App\Services\ProjectMember\Contracts\ProjectMemberDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectMemberRepository implements ProjectMemberRepositoryContract
{
    public function __construct(private readonly ProjectMemberDtoFactoryContract $projectMemberDtoFactory)
    {
    }

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

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        $projectMembers = ProjectMember::whereProjectId($projectId)->latest('created_at')->get();

        return $this->projectMemberDtoFactory->createFromModelsList($projectMembers);
    }
}

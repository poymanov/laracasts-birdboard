<?php

namespace App\Services\ProjectMember;

use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectMemberService implements ProjectMemberServiceContract
{
    public function __construct(
        private readonly ProjectMemberRepositoryContract $projectMemberRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(ProjectMemberCreateDto $projectMemberCreateDto): void
    {
        $this->projectMemberRepository->create($projectMemberCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        return $this->projectMemberRepository->findAllByProjectId($projectId);
    }
}

<?php

namespace App\Services\ProjectMember\Repositories;

use App\Models\ProjectMember;
use App\Services\ProjectMember\Contracts\ProjectMemberDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberCreateFailedException;
use App\Services\ProjectMember\Exceptions\ProjectMemberDeleteFailedException;
use App\Services\ProjectMember\Exceptions\ProjectMemberNotFoundException;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

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
    public function findOneById(Uuid $id): ProjectMemberDto
    {
        return $this->projectMemberDtoFactory->createFromModel($this->findModelById($id));
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        $projectMembers = ProjectMember::whereProjectId($projectId)->latest('created_at')->get();

        return $this->projectMemberDtoFactory->createFromModelsList($projectMembers);
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $projectMember = $this->findModelById($id);

        DB::beginTransaction();

        try {
            if (!$projectMember->delete() || !$projectMember->invite->delete()) {
                throw new ProjectMemberDeleteFailedException($id->value());
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToProject(Uuid $id, Uuid $projectId): bool
    {
        return ProjectMember::where(['id' => $id->value(), 'project_id' => $projectId->value()])->exists();
    }

    /**
     * @inheritDoc
     */
    public function isProjectMember(int $userId, Uuid $projectId): bool
    {
        return ProjectMember::where(['user_id' => $userId, 'project_id' => $projectId->value()])->exists();
    }

    /**
     * Получение модели по ID
     *
     * @param Uuid $id
     *
     * @return ProjectMember
     * @throws ProjectMemberNotFoundException
     */
    private function findModelById(Uuid $id): ProjectMember
    {
        $project = ProjectMember::find($id->value());

        if (!$project) {
            throw new ProjectMemberNotFoundException($id);
        }

        return $project;
    }
}

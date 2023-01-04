<?php

namespace App\Services\ProjectInvite\Repositories;

use App\Enums\ProjectInviteStatusEnum;
use App\Models\ProjectInvite;
use App\Services\ProjectInvite\Contracts\ProjectInviteDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteNotFoundException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteUpdateStatusFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectInviteRepository implements ProjectInviteRepositoryContract
{
    public function __construct(private readonly ProjectInviteDtoFactoryContract $inviteDtoFactory)
    {
    }

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

    /**
     * @inheritDoc
     */
    public function findAllByUserIdAndStatus(int $userId, ProjectInviteStatusEnum $status): array
    {
        $invites = ProjectInvite::where(['user_id' => $userId, 'status' => $status->value])->latest('created_at')->get();

        return $this->inviteDtoFactory->createFromModelsList($invites);
    }

    /**
     * @inheritDoc
     */
    public function updateStatus(Uuid $id, ProjectInviteStatusEnum $status): void
    {
        $projectInvite         = $this->findModelById($id);
        $projectInvite->status = $status->value;

        if (!$projectInvite->save()) {
            throw new ProjectInviteUpdateStatusFailedException($projectInvite->id);
        }
    }

    /**
     * @inheritDoc
     */
    public function isStatus(Uuid $id, ProjectInviteStatusEnum $status): bool
    {
        return ProjectInvite::where(['id' => $id->value(), 'status' => $status->value])->exists();
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool
    {
        return ProjectInvite::where(['id' => $id->value(), 'user_id' => $userId])->exists();
    }

    /**
     * Получение модели по ID
     *
     * @param Uuid $id
     *
     * @return ProjectInvite
     * @throws ProjectInviteNotFoundException
     */
    private function findModelById(Uuid $id): ProjectInvite
    {
        $projectInvite = ProjectInvite::find($id->value());

        if (!$projectInvite) {
            throw new ProjectInviteNotFoundException($id->value());
        }

        return $projectInvite;
    }
}

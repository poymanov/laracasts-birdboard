<?php

namespace App\Services\ProjectMember;

use App\Enums\CacheKeysEnum;
use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\ProjectInvite\Notifications\DeleteMember;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberWrongMemberException;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectMemberService implements ProjectMemberServiceContract
{
    public function __construct(
        private readonly ProjectMemberRepositoryContract $projectMemberRepository,
        private readonly ProjectServiceContract $projectService,
        private readonly NotificationServiceContract $notificationService,
        private readonly ProjectActivityServiceContract $projectActivityService,
        private readonly Repository $cacheService,
        private readonly array $cacheTags,
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


    /**
     * @inheritDoc
     */
    public function delete(Uuid $projectId, Uuid $projectMemberId): void
    {
        // Попытка удаления участника, не относящегося к проекту
        if (!$this->projectMemberRepository->isBelongsToProject($projectMemberId, $projectId)) {
            throw new ProjectMemberWrongMemberException();
        }

        $projectMember = $this->projectMemberRepository->findOneById($projectMemberId);
        $project       = $this->projectService->findOneById($projectId);

        DB::beginTransaction();

        try {
            // Удаление участника проекта
            $this->projectMemberRepository->delete($projectMemberId);

            // Отправка ему почтового уведомления
            $this->notificationService->mail($projectMember->user->id, new DeleteMember($project));

            // Создание активности проекта
            $this->projectActivityService->createDeleteMember($projectMember->user->id, $projectId);

            // Удаление кэша проектов участника проекта
            $this->cacheService
                ->tags($this->cacheTags)
                ->delete(CacheKeysEnum::USER_PROJECTS->value . $projectMember->user->id);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function isProjectMember(int $userId, Uuid $projectId): bool
    {
        return $this->projectMemberRepository->isProjectMember($userId, $projectId);
    }
}

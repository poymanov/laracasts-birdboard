<?php

namespace App\Services\ProjectMember;

use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Notifications\DeleteMember;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Dtos\ProjectMemberCreateDto;
use App\Services\ProjectMember\Exceptions\ProjectMemberWrongMemberException;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectMemberService implements ProjectMemberServiceContract
{
    public function __construct(
        private readonly ProjectMemberRepositoryContract $projectMemberRepository,
        private readonly ProjectServiceContract $projectService,
        private readonly NotificationServiceContract $notificationService
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
        $project = $this->projectService->findOneById($projectId);

        DB::beginTransaction();

        try {
            // Удаление участника проекта
            $this->projectMemberRepository->delete($projectMemberId);

            // Отправка ему почтового уведомления
            $this->notificationService->mail($projectMember->user->id, new DeleteMember($project));

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }
}

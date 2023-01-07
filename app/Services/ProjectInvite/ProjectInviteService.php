<?php

namespace App\Services\ProjectInvite;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAcceptAnotherUserException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectAnotherUserException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectWrongStatusException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteSelfCreateException;
use App\Services\ProjectInvite\Factories\ProjectInviteCreateDtoFactory;
use App\Services\ProjectInvite\Notifications\AcceptInvite;
use App\Services\ProjectInvite\Notifications\NewInvite;
use App\Services\ProjectInvite\Notifications\RejectInvite;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Factories\ProjectMemberCreateDtoFactory;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectInviteService implements ProjectInviteServiceContract
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly UserServiceContract $userService,
        private readonly ProjectInviteRepositoryContract $projectInviteRepository,
        private readonly ProjectInviteCreateDtoFactory $inviteCreateDtoFactory,
        private readonly ProjectMemberCreateDtoFactory $projectMemberCreateDtoFactory,
        private readonly ProjectMemberServiceContract $projectMemberService,
        private readonly NotificationServiceContract $notificationService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(Uuid $projectId, Email $email): void
    {
        $user = $this->userService->findByEmail($email);

        // Попытка приглашения в проект его же владельца
        if ($this->projectService->isBelongsToUser($user->id, $projectId)) {
            throw new ProjectInviteSelfCreateException();
        }

        // Попытка приглашения уже приглашенного пользователя
        if ($this->projectInviteRepository->isExistsByProjectIdAndUserId($projectId, $user->id)) {
            throw new ProjectInviteAlreadyException($email);
        }

        // Получение проекта
        $project = $this->projectService->findOneById($projectId);

        $inviteCreateDto = $this->inviteCreateDtoFactory->createFromParams($projectId, $user->id);

        DB::beginTransaction();

        try {
            // Создание приглашения
            $this->projectInviteRepository->create($inviteCreateDto);

            // Отправка уведомления приглашенному пользователю
            $this->notificationService->mail($user->id, new NewInvite($project));

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllSentByUserId(int $userId): array
    {
        return $this->projectInviteRepository->findAllByUserIdAndStatus($userId, ProjectInviteStatusEnum::SENT);
    }

    /**
     * @inheritDoc
     */
    public function reject(Uuid $id, int $userId): void
    {
        // Попытка отклонения чужого приглашения
        if (!$this->projectInviteRepository->isBelongsToUser($id, $userId)) {
            throw new ProjectInviteRejectAnotherUserException();
        }

        // Попытка отклонения в неправильном статусе
        if (!$this->projectInviteRepository->isStatus($id, ProjectInviteStatusEnum::SENT)) {
            throw new ProjectInviteRejectWrongStatusException();
        }

        $projectInvite = $this->projectInviteRepository->findOneById($id);

        DB::beginTransaction();

        try {
            // Отклонение приглашения
            $this->projectInviteRepository->updateStatus($id, ProjectInviteStatusEnum::REJECTED);

            // Отправка уведомления владельцу проекта
            $this->notificationService->mail($projectInvite->project->owner->id, new RejectInvite($projectInvite));

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }

    /**
     * @inheritDoc
     */
    public function accept(Uuid $id, int $userId): void
    {
        // Попытка подтверждения чужого приглашения
        if (!$this->projectInviteRepository->isBelongsToUser($id, $userId)) {
            throw new ProjectInviteAcceptAnotherUserException();
        }

        // Попытка подтверждения в неправильном статусе
        if (!$this->projectInviteRepository->isStatus($id, ProjectInviteStatusEnum::SENT)) {
            throw new ProjectInviteAcceptAnotherUserException();
        }

        DB::beginTransaction();

        try {
            // Получение приглашения
            $projectInvite = $this->projectInviteRepository->findOneById($id);

            // Изменение статуса приглашения
            $this->projectInviteRepository->updateStatus($id, ProjectInviteStatusEnum::ACCEPTED);

            // Добавление пользователя в участники проекта
            $projectMemberCreateDto = $this->projectMemberCreateDtoFactory->createFromParams(
                $projectInvite->user->id,
                Uuid::make($projectInvite->project->id),
                Uuid::make($projectInvite->id)
            );
            $this->projectMemberService->create($projectMemberCreateDto);

            // Отправка уведомления владельцу проекта
            $this->notificationService->mail($projectInvite->project->owner->id, new AcceptInvite($projectInvite));

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }
}

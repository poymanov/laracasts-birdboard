<?php

namespace App\Services\ProjectInvite;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectAnotherUserException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectWrongStatusException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteSelfCreateException;
use App\Services\ProjectInvite\Factories\ProjectInviteCreateDtoFactory;
use App\Services\User\Contracts\UserServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectInviteService implements ProjectInviteServiceContract
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly UserServiceContract $userService,
        private readonly ProjectInviteRepositoryContract $projectInviteRepository,
        private readonly ProjectInviteCreateDtoFactory $inviteCreateDtoFactory
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

        $inviteCreateDto = $this->inviteCreateDtoFactory->createFromParams($projectId, $user->id);

        $this->projectInviteRepository->create($inviteCreateDto);
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

        $this->projectInviteRepository->updateStatus($id, ProjectInviteStatusEnum::REJECTED);
    }
}

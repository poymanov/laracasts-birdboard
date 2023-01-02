<?php

namespace App\Services\ProjectInvite;

use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException;
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
        private readonly ProjectInviteRepositoryContract $inviteRepository,
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
        if ($this->inviteRepository->isExistsByProjectIdAndUserId($projectId, $user->id)) {
            throw new ProjectInviteAlreadyException($email);
        }

        $inviteCreateDto = $this->inviteCreateDtoFactory->createFromParams($projectId, $user->id);

        $this->inviteRepository->create($inviteCreateDto);
    }
}

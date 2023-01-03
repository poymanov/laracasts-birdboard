<?php

namespace App\Services\ProjectInvite\Factories;

use App\Enums\ProjectInviteStatusEnum;
use App\Models\ProjectInvite;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteDtoFactoryContract;
use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use App\Services\User\Contracts\UserDtoFactoryContract;
use Illuminate\Database\Eloquent\Collection;

class ProjectInviteDtoFactory implements ProjectInviteDtoFactoryContract
{
    public function __construct(
        private readonly ProjectDtoFactoryContract $projectDtoFactory,
        private readonly UserDtoFactoryContract $userDtoFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createFromModel(ProjectInvite $invite): ProjectInviteDto
    {
        $inviteDto          = new ProjectInviteDto();
        $inviteDto->id      = $invite->id;
        $inviteDto->project = $this->projectDtoFactory->createFromModel($invite->project);
        $inviteDto->user    = $this->userDtoFactory->createFromModel($invite->user);
        $inviteDto->status  = ProjectInviteStatusEnum::from($invite->status);

        return $inviteDto;
    }

    /**
     * @inheritDoc
     */
    public function createFromModelsList(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = $this->createFromModel($model);
        }

        return $dtos;
    }
}

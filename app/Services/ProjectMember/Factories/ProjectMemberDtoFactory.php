<?php

namespace App\Services\ProjectMember\Factories;

use App\Models\ProjectMember;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberDtoFactoryContract;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use App\Services\User\Contracts\UserDtoFactoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ProjectMemberDtoFactory implements ProjectMemberDtoFactoryContract
{
    public function __construct(
        private readonly ProjectDtoFactoryContract $projectDtoFactory,
        private readonly UserDtoFactoryContract $userDtoFactory
    ) {
    }

    /**
     * Создание DTO из модели
     *
     * @param ProjectMember $projectMember
     *
     * @return ProjectMemberDto
     * @throws Exception
     */
    public function createFromModel(ProjectMember $projectMember): ProjectMemberDto
    {
        $projectMemberDto           = new ProjectMemberDto();
        $projectMemberDto->id       = $projectMember->id;
        $projectMemberDto->project  = $this->projectDtoFactory->createFromModel($projectMember->project);
        $projectMemberDto->user     = $this->userDtoFactory->createFromModel($projectMember->user);
        $projectMemberDto->inviteId = $projectMember->invite_id;

        return $projectMemberDto;
    }

    /**
     * Создание DTO из списка моделей
     *
     * @param Collection $models
     *
     * @return array
     * @throws Exception
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

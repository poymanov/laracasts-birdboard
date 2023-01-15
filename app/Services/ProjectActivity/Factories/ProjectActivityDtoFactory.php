<?php

namespace App\Services\ProjectActivity\Factories;

use App\Models\ProjectActivity;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityDtoFactoryContract;
use App\Services\ProjectActivity\Dtos\ProjectActivityDto;
use App\Services\User\Contracts\UserDtoFactoryContract;
use Illuminate\Database\Eloquent\Collection;

class ProjectActivityDtoFactory implements ProjectActivityDtoFactoryContract
{
    public function __construct(
        private readonly UserDtoFactoryContract $userDtoFactory,
        private readonly ProjectDtoFactoryContract $projectDtoFactory
    ) {
    }


    /**
     * @inheritDoc
     */
    public function createFromModel(ProjectActivity $projectActivity): ProjectActivityDto
    {
        $projectActivityDto                         = new ProjectActivityDto();
        $projectActivityDto->id                     = $projectActivity->id;
        $projectActivityDto->user                   = $this->userDtoFactory->createFromModel($projectActivity->user);
        $projectActivityDto->project                = $this->projectDtoFactory->createFromModel($projectActivity->project);
        $projectActivityDto->type                   = $projectActivity->type;
        $projectActivityDto->oldValue               = $projectActivity->old_value;
        $projectActivityDto->newValue               = $projectActivity->new_value;
        $projectActivityDto->createdAtDiffForHumans = $projectActivity->created_at?->diffForHumans();

        return $projectActivityDto;
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

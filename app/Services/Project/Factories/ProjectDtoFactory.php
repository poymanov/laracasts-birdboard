<?php

namespace App\Services\Project\Factories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\Project\Dtos\ProjectDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProjectDtoFactory implements ProjectDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(Project $project): ProjectDto
    {
        $projectDto                   = new ProjectDto();
        $projectDto->id               = $project->id;
        $projectDto->ownerId          = $project->owner_id;
        $projectDto->title            = $project->title;
        $projectDto->shortDescription = Str::limit($project->description, 100);
        $projectDto->description      = $project->description;
        $projectDto->createdAt        = $project->created_at?->toDateTime();
        $projectDto->updateAt         = $project->updated_at?->toDateTime();

        return $projectDto;
    }

    /**
     * @param Collection $models
     *
     * @return array
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

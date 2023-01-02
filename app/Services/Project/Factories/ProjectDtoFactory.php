<?php

namespace App\Services\Project\Factories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\Project\Dtos\ProjectDto;
use App\Services\User\Contracts\UserDtoFactoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProjectDtoFactory implements ProjectDtoFactoryContract
{
    public function __construct(public readonly UserDtoFactoryContract $userDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function createFromModel(Project $project): ProjectDto
    {
        if (is_null($project->owner)) {
            throw new Exception('Owner required for project');
        }

        $projectDto                   = new ProjectDto();
        $projectDto->id               = $project->id;
        $projectDto->title            = $project->title;
        $projectDto->shortDescription = Str::limit($project->description);
        $projectDto->description      = $project->description;
        $projectDto->notes            = $project->notes;
        $projectDto->owner            = $this->userDtoFactory->createFromModel($project->owner);
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

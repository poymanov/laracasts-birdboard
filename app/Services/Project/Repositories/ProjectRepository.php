<?php

namespace App\Services\Project\Repositories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Exceptions\ProjectCreateFailedException;

class ProjectRepository implements ProjectRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ProjectCreateDto $projectCreateDto): void
    {
        $project              = new Project();
        $project->title       = $projectCreateDto->title;
        $project->description = $projectCreateDto->description;
        $project->owner_id    = $projectCreateDto->ownerId;

        if (!$project->save()) {
            throw new ProjectCreateFailedException();
        }
    }
}

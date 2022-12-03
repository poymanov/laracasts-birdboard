<?php

namespace App\Services\Project\Repositories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\Project\Exceptions\ProjectUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

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

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, ProjectUpdateDto $projectUpdateDto): void
    {
        $project              = $this->findModelById($id);
        $project->title       = $projectUpdateDto->title;
        $project->description = $projectUpdateDto->description;

        if (!$project->save()) {
            throw new ProjectUpdateFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(int $userId, Uuid $projectId): bool
    {
        return Project::where(['id' => $projectId->value(), 'owner_id' => $userId])->exists();
    }

    /**
     * Получение модели по ID
     *
     * @param Uuid $id
     *
     * @return Project
     * @throws ProjectNotFoundException
     */
    private function findModelById(Uuid $id): Project
    {
        $project = Project::find($id->value());

        if (!$project) {
            throw new ProjectNotFoundException($id);
        }

        return $project;
    }
}

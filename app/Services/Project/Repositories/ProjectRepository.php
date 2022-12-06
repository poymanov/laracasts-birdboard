<?php

namespace App\Services\Project\Repositories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use App\Services\Project\Exceptions\ProjectDeleteFailedException;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\Project\Exceptions\ProjectUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectRepository implements ProjectRepositoryContract
{
    public function __construct(private readonly ProjectDtoFactoryContract $projectDtoFactory)
    {
    }

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
    public function delete(Uuid $id): void
    {
        $project = $this->findModelById($id);

        if (!$project->delete()) {
            throw new ProjectDeleteFailedException($id);
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
     * @inheritDoc
     */
    public function findAllByOwnerId(int $ownerId): array
    {
        return $this->projectDtoFactory->createFromModelsList(Project::whereOwnerId($ownerId)->get());
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

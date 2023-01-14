<?php

namespace App\Services\Project\Repositories;

use App\Models\Project;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectDto;
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
    public function create(ProjectCreateDto $projectCreateDto): string
    {
        $project              = new Project();
        $project->title       = $projectCreateDto->title;
        $project->description = $projectCreateDto->description;
        $project->owner_id    = $projectCreateDto->ownerId;

        if (!$project->save()) {
            throw new ProjectCreateFailedException();
        }

        $project->refresh();

        return $project->id;
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
    public function findAllByUserId(int $userId): array
    {
        $projects = Project::where('owner_id', $userId)
            ->orWhereHas('members', fn ($query) => $query->where('user_id', $userId))
            ->latest('updated_at')
            ->get();

        return $this->projectDtoFactory->createFromModelsList($projects);
    }

    /**
     * @inheritDoc
     */
    public function findOneById(Uuid $id): ProjectDto
    {
        return $this->projectDtoFactory->createFromModel($this->findModelById($id));
    }

    /**
     * @inheritDoc
     */
    public function updateNotes(Uuid $id, string $notes): void
    {
        $project        = $this->findModelById($id);
        $project->notes = $notes;

        if (!$project->save()) {
            throw new ProjectUpdateFailedException($id);
        }
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

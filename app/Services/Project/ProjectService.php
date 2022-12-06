<?php

namespace App\Services\Project;

use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private readonly ProjectRepositoryContract $projectRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(ProjectCreateDto $projectCreateDto): void
    {
        $this->projectRepository->create($projectCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, ProjectUpdateDto $projectUpdateDto): void
    {
        $this->projectRepository->update($id, $projectUpdateDto);
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $this->projectRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(int $userId, Uuid $projectId): bool
    {
        return $this->projectRepository->isBelongsToUser($userId, $projectId);
    }

    /**
     * @inheritDoc
     */
    public function findAllByOwnerId(int $ownerId): array
    {
        return $this->projectRepository->findAllByOwnerId($ownerId);
    }
}

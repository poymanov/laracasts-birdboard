<?php

namespace App\Services\Project;

use App\Enums\CacheKeysEnum;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use Illuminate\Cache\Repository;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private readonly ProjectRepositoryContract $projectRepository,
        private readonly Repository $cacheService,
        private readonly array $cacheTags,
        private readonly int $cacheTtl
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

        $this->cacheService->tags($this->cacheTags)->flush();
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $this->projectRepository->delete($id);

        $this->cacheService->tags($this->cacheTags)->flush();
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
    public function findAllByUserId(int $userId): array
    {
        return $this->cacheService
            ->tags($this->cacheTags)
            ->remember(CacheKeysEnum::USER_PROJECTS->value . $userId, $this->cacheTtl, function () use ($userId) {
                return $this->projectRepository->findAllByUserId($userId);
            });
    }

    /**
     * @inheritDoc
     */
    public function findOneById(Uuid $id): ProjectDto
    {
        return $this->projectRepository->findOneById($id);
    }

    /**
     * @inheritDoc
     */
    public function updateNotes(Uuid $id, string $notes): void
    {
        $this->projectRepository->updateNotes($id, $notes);

        $this->cacheService->tags($this->cacheTags)->flush();
    }
}

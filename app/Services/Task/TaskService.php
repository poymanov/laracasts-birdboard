<?php

namespace App\Services\Task;

use App\Enums\CacheKeysEnum;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskNotBelongsToProject;
use Illuminate\Cache\Repository;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskService implements TaskServiceContract
{
    public function __construct(
        private readonly TaskRepositoryContract $taskRepository,
        private readonly Repository $cacheService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(TaskCreateDto $taskCreateDto): void
    {
        $this->taskRepository->create($taskCreateDto);

        $this->cacheService->forget($this->getCacheKey($taskCreateDto->projectId));
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, TaskUpdateDto $taskUpdateDto): void
    {
        if (!$this->taskRepository->isBelongsToProject($id, $taskUpdateDto->projectId)) {
            throw new TaskNotBelongsToProject($id->value(), $taskUpdateDto->projectId->value());
        }

        $this->taskRepository->update($id, $taskUpdateDto);

        $this->cacheService->forget($this->getCacheKey($taskUpdateDto->projectId));
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        return $this->cacheService
            ->remember($this->getCacheKey($projectId), $this->cacheTtl, function () use ($projectId) {
                return $this->taskRepository->findAllByProjectId($projectId);
            });
    }

    /**
     * Получение ключа для кэша
     *
     * @param Uuid $projectId
     *
     * @return string
     */
    private function getCacheKey(Uuid $projectId): string
    {
        return CacheKeysEnum::PROJECT_TASKS->value . $projectId->value();
    }
}

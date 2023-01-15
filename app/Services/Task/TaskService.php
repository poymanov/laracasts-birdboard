<?php

namespace App\Services\Task;

use App\Enums\CacheKeysEnum;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskNotBelongsToProject;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class TaskService implements TaskServiceContract
{
    public function __construct(
        private readonly TaskRepositoryContract $taskRepository,
        private readonly ProjectActivityServiceContract $projectActivityService,
        private readonly Repository $cacheService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, TaskCreateDto $taskCreateDto): void
    {
        DB::beginTransaction();

        try {
            $this->taskRepository->create($taskCreateDto);
            $this->cacheService->forget($this->getCacheKey($taskCreateDto->projectId));

            $this->projectActivityService->createCreateTask($userId, $taskCreateDto->projectId, $taskCreateDto->body);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, int $userId, TaskUpdateDto $taskUpdateDto): void
    {
        if (!$this->taskRepository->isBelongsToProject($id, $taskUpdateDto->projectId)) {
            throw new TaskNotBelongsToProject($id->value(), $taskUpdateDto->projectId->value());
        }

        DB::beginTransaction();

        try {
            $task = $this->taskRepository->findOneById($id);

            $this->taskRepository->update($id, $taskUpdateDto);
            $this->cacheService->forget($this->getCacheKey($taskUpdateDto->projectId));

            if ($task->body !== $taskUpdateDto->body) {
                $this->projectActivityService->createUpdateTask($userId, $taskUpdateDto->projectId, $task->body, $taskUpdateDto->body);
            }

            if ($task->completed !== $taskUpdateDto->completed) {
                if ($taskUpdateDto->completed) {
                    $this->projectActivityService->createCompleteTask($userId, $taskUpdateDto->projectId, $task->body);
                } else {
                    $this->projectActivityService->createIncompleteTask($userId, $taskUpdateDto->projectId, $task->body);
                }
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
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

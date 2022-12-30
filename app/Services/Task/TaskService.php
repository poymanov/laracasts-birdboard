<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskNotBelongsToProject;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskService implements TaskServiceContract
{
    public function __construct(
        private readonly TaskRepositoryContract $taskRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(TaskCreateDto $taskCreateDto): void
    {
        $this->taskRepository->create($taskCreateDto);
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
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        return $this->taskRepository->findAllByProjectId($projectId);
    }
}

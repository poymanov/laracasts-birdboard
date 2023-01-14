<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskDtoFactoryContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskRepository implements TaskRepositoryContract
{
    public function __construct(private readonly TaskDtoFactoryContract $taskDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(TaskCreateDto $taskCreateDto): string
    {
        $task             = new Task();
        $task->body       = $taskCreateDto->body;
        $task->project_id = $taskCreateDto->projectId->value();

        if (!$task->save()) {
            throw new TaskCreateFailedException();
        }

        $task->refresh();

        return $task->id;
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, TaskUpdateDto $taskUpdateDto): void
    {
        $task            = $this->findModelById($id);
        $task->body      = $taskUpdateDto->body;
        $task->completed = $taskUpdateDto->completed;

        if (!$task->save()) {
            throw new TaskUpdateFailedException($id->value());
        }
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToProject(Uuid $taskId, Uuid $projectId): bool
    {
        return Task::where(['id' => $taskId->value(), 'project_id' => $projectId->value()])->exists();
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        return $this->taskDtoFactory->createFromModelsList(Task::whereProjectId($projectId)->oldest('created_at')->get());
    }

    /**
     * @inheritDoc
     */
    public function findOneById(Uuid $id): TaskDto
    {
        return $this->taskDtoFactory->createFromModel($this->findModelById($id));
    }

    /**
     * Получение модели по ID
     *
     * @param Uuid $id
     *
     * @return Task
     * @throws TaskNotFoundException
     */
    private function findModelById(Uuid $id): Task
    {
        $task = Task::find($id->value());

        if (!$task) {
            throw new TaskNotFoundException($id->value());
        }

        return $task;
    }
}

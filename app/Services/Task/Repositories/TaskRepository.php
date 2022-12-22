<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskRepository implements TaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(TaskCreateDto $taskCreateDto): void
    {
        $task             = new Task();
        $task->body       = $taskCreateDto->body;
        $task->project_id = $taskCreateDto->projectId->value();

        if (!$task->save()) {
            throw new TaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, TaskUpdateDto $taskUpdateDto): void
    {
        $task = $this->findModelById($id);
        $task->body = $taskUpdateDto->body;
        $task->completed = $taskUpdateDto->completed;

        if (!$task->save()) {
            throw new TaskUpdateFailedException($id->value());
        }
    }

    /**
     * Принадлежит ли задачу проекту
     *
     * @param Uuid $taskId
     * @param Uuid $projectId
     *
     * @return bool
     */
    public function isBelongsToProject(Uuid $taskId, Uuid $projectId): bool
    {
        return Task::where(['id' => $taskId->value(), 'project_id' => $projectId->value()])->exists();
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

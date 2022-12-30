<?php

namespace App\Services\Task\Factories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskDtoFactoryContract;
use App\Services\Task\Dtos\TaskDto;
use Illuminate\Database\Eloquent\Collection;

class TaskDtoFactory implements TaskDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(Task $task): TaskDto
    {
        $taskDto            = new TaskDto();
        $taskDto->id        = $task->id;
        $taskDto->projectId = $task->project_id;
        $taskDto->body      = $task->body;
        $taskDto->completed = $task->completed;
        $taskDto->createdAt = $task->created_at?->toDateTime();
        $taskDto->updatedAt = $task->updated_at?->toDateTime();

        return $taskDto;
    }

    /**
     * @inheritDoc
     */
    public function createFromModelsList(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = $this->createFromModel($model);
        }

        return $dtos;
    }
}

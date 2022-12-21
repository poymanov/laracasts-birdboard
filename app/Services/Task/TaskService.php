<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;

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
}

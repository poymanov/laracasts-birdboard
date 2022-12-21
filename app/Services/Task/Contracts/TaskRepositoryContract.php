<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;

interface TaskRepositoryContract
{
    /**
     * Создание задачи
     *
     * @param TaskCreateDto $taskCreateDto
     *
     * @return void
     * @throws TaskCreateFailedException
     */
    public function create(TaskCreateDto $taskCreateDto): void;
}

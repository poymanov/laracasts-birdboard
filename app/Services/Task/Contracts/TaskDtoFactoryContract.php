<?php

namespace App\Services\Task\Contracts;

use App\Models\Task;
use App\Services\Task\Dtos\TaskDto;
use Illuminate\Database\Eloquent\Collection;

interface TaskDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param Task $project
     *
     * @return TaskDto
     */
    public function createFromModel(Task $project): TaskDto;

    /**
     * Создание DTO из списка моделей
     *
     * @param Collection $models
     *
     * @return TaskDto[]
     */
    public function createFromModelsList(Collection $models): array;
}

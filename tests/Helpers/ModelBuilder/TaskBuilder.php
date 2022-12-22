<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Task;

class TaskBuilder
{
    /**
     * Подготовка сущности {@see Task}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Task
     */
    public function make(array $params = []): Task
    {
        return Task::factory()->make($params);
    }

    /**
     * Создание сущности {@see Task}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Task
     */
    public function create(array $params = []): Task
    {
        return Task::factory()->create($params);
    }
}

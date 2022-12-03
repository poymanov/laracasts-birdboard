<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Project;

class ProjectBuilder
{
    /**
     * Подготовка сущности {@see Project}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Project
     */
    public function make(array $params = []): Project
    {
        return Project::factory()->make($params);
    }

    /**
     * Создание сущности {@see Project}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Project
     */
    public function create(array $params = []): Project
    {
        return Project::factory()->createOne($params);
    }
}

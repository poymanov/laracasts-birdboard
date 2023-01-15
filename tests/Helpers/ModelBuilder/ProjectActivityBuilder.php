<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ProjectActivity;

class ProjectActivityBuilder
{
    /**
     * Создание сущности {@see ProjectActivity}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ProjectActivity
     */
    public function create(array $params = []): ProjectActivity
    {
        return ProjectActivity::factory()->createOne($params);
    }
}

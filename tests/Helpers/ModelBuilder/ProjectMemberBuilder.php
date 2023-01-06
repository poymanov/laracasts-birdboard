<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ProjectMember;

class ProjectMemberBuilder
{
    /**
     * Подготовка сущности {@see ProjectMember}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ProjectMember
     */
    public function make(array $params = []): ProjectMember
    {
        return ProjectMember::factory()->make($params);
    }

    /**
     * Создание сущности {@see ProjectMember}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ProjectMember
     */
    public function create(array $params = []): ProjectMember
    {
        return ProjectMember::factory()->create($params);
    }
}

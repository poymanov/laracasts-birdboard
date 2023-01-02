<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ProjectInvite;

class ProjectInviteBuilder
{
    /**
     * Создание сущности {@see ProjectInvite}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ProjectInvite
     */
    public function create(array $params = []): ProjectInvite
    {
        return ProjectInvite::factory()->createOne($params);
    }
}

<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Exceptions\ProjectCreateFailedException;

interface ProjectServiceContract
{
    /**
     * Создание сущности
     *
     * @param string $title
     * @param string $description
     * @param int    $ownerId
     *
     * @return void
     * @throws ProjectCreateFailedException
     */
    public function create(string $title, string $description, int $ownerId): void;
}

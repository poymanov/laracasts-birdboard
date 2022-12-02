<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Dtos\ProjectCreateDto;

interface ProjectCreateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param string $title
     * @param string $description
     * @param int    $ownerId
     *
     * @return ProjectCreateDto
     */
    public function createFromParams(string $title, string $description, int $ownerId): ProjectCreateDto;
}

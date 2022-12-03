<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Dtos\ProjectUpdateDto;

interface ProjectUpdateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param string $title
     * @param string $description
     *
     * @return ProjectUpdateDto
     */
    public function createFromParams(string $title, string $description): ProjectUpdateDto;
}

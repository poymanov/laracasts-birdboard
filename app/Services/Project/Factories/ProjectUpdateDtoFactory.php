<?php

namespace App\Services\Project\Factories;

use App\Services\Project\Contracts\ProjectUpdateDtoFactoryContract;
use App\Services\Project\Dtos\ProjectUpdateDto;

class ProjectUpdateDtoFactory implements ProjectUpdateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $title, string $description): ProjectUpdateDto
    {
        $projectUpdateDto              = new ProjectUpdateDto();
        $projectUpdateDto->title       = $title;
        $projectUpdateDto->description = $description;

        return $projectUpdateDto;
    }
}

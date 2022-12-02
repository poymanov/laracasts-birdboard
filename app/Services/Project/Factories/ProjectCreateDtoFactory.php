<?php

namespace App\Services\Project\Factories;

use App\Services\Project\Contracts\ProjectCreateDtoFactoryContract;
use App\Services\Project\Dtos\ProjectCreateDto;

class ProjectCreateDtoFactory implements ProjectCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $title, string $description, int $ownerId): ProjectCreateDto
    {
        $projectCreateDto              = new ProjectCreateDto();
        $projectCreateDto->ownerId     = $ownerId;
        $projectCreateDto->title       = $title;
        $projectCreateDto->description = $description;

        return $projectCreateDto;
    }
}

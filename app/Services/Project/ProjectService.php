<?php

namespace App\Services\Project;

use App\Services\Project\Contracts\ProjectCreateDtoFactoryContract;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private readonly ProjectRepositoryContract $projectRepository,
        private readonly ProjectCreateDtoFactoryContract $projectCreateDtoFactoryContract
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(string $title, string $description, int $ownerId): void
    {
        $projectCreateDto = $this->projectCreateDtoFactoryContract->createFromParams($title, $description, $ownerId);

        $this->projectRepository->create($projectCreateDto);
    }
}

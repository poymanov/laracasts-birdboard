<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Exceptions\ProjectCreateFailedException;

interface ProjectRepositoryContract
{
    /**
     * @param ProjectCreateDto $projectCreateDto
     *
     * @return void
     * @throws ProjectCreateFailedException
     */
    public function create(ProjectCreateDto $projectCreateDto): void;
}

<?php

namespace App\Services\ProjectActivity\Contracts;

use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use App\Services\ProjectActivity\Exceptions\ProjectActivityCreateFailedException;

interface ProjectActivityRepositoryContract
{
    /**
     * Создание активности по проекту
     *
     * @param ProjectActivityCreateDto $projectActivityCreateDto
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function create(ProjectActivityCreateDto $projectActivityCreateDto): void;
}

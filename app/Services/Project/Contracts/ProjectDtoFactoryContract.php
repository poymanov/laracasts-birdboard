<?php

namespace App\Services\Project\Contracts;

use App\Models\Project;
use App\Services\Project\Dtos\ProjectDto;
use Illuminate\Database\Eloquent\Collection;

interface ProjectDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param Project $project
     *
     * @return ProjectDto
     */
    public function createFromModel(Project $project): ProjectDto;

    /**
     * Создание DTO из списка моделей
     *
     * @param Collection $models
     *
     * @return ProjectDto[]
     */
    public function createFromModelsList(Collection $models): array;
}

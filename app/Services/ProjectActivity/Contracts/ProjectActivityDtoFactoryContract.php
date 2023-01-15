<?php

namespace App\Services\ProjectActivity\Contracts;

use App\Models\ProjectActivity;
use App\Services\ProjectActivity\Dtos\ProjectActivityDto;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface ProjectActivityDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param ProjectActivity $projectActivity
     *
     * @return ProjectActivityDto
     *
     * @throws Exception
     */
    public function createFromModel(ProjectActivity $projectActivity): ProjectActivityDto;

    /**
     * Создание DTO из списка моделей
     *
     * @param Collection $models
     *
     * @return array
     */
    public function createFromModelsList(Collection $models): array;
}

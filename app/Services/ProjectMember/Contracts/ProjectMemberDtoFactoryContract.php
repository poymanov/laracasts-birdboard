<?php

namespace App\Services\ProjectMember\Contracts;

use App\Models\ProjectMember;
use App\Services\ProjectMember\Dtos\ProjectMemberDto;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface ProjectMemberDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param ProjectMember $projectMember
     *
     * @return ProjectMemberDto
     * @throws Exception
     */
    public function createFromModel(ProjectMember $projectMember): ProjectMemberDto;

    /**
     * Создание DTO из списка моделей
     *
     * @param Collection $models
     *
     * @return array
     * @throws Exception
     */
    public function createFromModelsList(Collection $models): array;
}

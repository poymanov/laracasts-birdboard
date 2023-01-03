<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Models\ProjectInvite;
use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface ProjectInviteDtoFactoryContract
{
    /**
     * Создание DTO из модели
     *
     * @param ProjectInvite $invite
     *
     * @return ProjectInviteDto
     * @throws Exception
     */
    public function createFromModel(ProjectInvite $invite): ProjectInviteDto;

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

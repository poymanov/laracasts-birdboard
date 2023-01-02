<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Services\ProjectInvite\Dtos\ProjectInviteCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectInviteCreateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param Uuid $projectId
     * @param int $userId
     *
     * @return ProjectInviteCreateDto
     */
    public function createFromParams(Uuid $projectId, int $userId): ProjectInviteCreateDto;
}

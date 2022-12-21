<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface TaskCreateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param Uuid   $projectId
     * @param string $body
     *
     * @return TaskCreateDto
     */
    public function createFromParams(Uuid $projectId, string $body): TaskCreateDto;
}

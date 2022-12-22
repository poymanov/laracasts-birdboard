<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskUpdateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface TaskUpdateDtoFactoryContract
{
    /**
     * Создание из параметров
     *
     * @param string $body
     * @param bool   $completed
     * @param Uuid   $projectId
     *
     * @return TaskUpdateDto
     */
    public function createFromParams(string $body, bool $completed, Uuid $projectId): TaskUpdateDto;
}

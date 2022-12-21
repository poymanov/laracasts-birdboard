<?php

namespace App\Services\Task\Factories;

use App\Services\Task\Contracts\TaskCreateDtoFactoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskCreateDtoFactory implements TaskCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(Uuid $projectId, string $body): TaskCreateDto
    {
        $taskCreateDto            = new TaskCreateDto();
        $taskCreateDto->projectId = $projectId;
        $taskCreateDto->body      = $body;

        return $taskCreateDto;
    }
}

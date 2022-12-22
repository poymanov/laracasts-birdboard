<?php

namespace App\Services\Task\Factories;

use App\Services\Task\Contracts\TaskUpdateDtoFactoryContract;
use App\Services\Task\Dtos\TaskUpdateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskUpdateDtoFactory implements TaskUpdateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $body, bool $completed, Uuid $projectId): TaskUpdateDto
    {
        $taskUpdateDto            = new TaskUpdateDto();
        $taskUpdateDto->body      = $body;
        $taskUpdateDto->completed = $completed;
        $taskUpdateDto->projectId = $projectId;

        return $taskUpdateDto;
    }
}

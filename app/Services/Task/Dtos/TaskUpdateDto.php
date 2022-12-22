<?php

namespace App\Services\Task\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskUpdateDto
{
    public string $body;

    public bool $completed;

    public Uuid $projectId;
}

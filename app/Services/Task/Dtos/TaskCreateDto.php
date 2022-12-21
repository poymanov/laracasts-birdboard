<?php

namespace App\Services\Task\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class TaskCreateDto
{
    public string $body;

    public Uuid $projectId;
}

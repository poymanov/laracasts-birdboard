<?php

namespace App\Services\Task\Dtos;

use DateTime;

class TaskDto
{
    public string $id;

    public string $projectId;

    public string $body;

    public bool $completed;

    public ?DateTime $createdAt;

    public ?DateTime $updatedAt;
}

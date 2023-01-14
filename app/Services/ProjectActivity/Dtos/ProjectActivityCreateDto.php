<?php

namespace App\Services\ProjectActivity\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectActivityCreateDto
{
    public int $userId;

    public Uuid $projectId;

    public string $type;

    public ?string $oldValue = null;

    public ?string $newValue = null;
}

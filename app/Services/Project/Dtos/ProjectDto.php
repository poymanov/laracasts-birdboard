<?php

namespace App\Services\Project\Dtos;

use DateTime;

class ProjectDto
{
    public string $id;

    public int $ownerId;

    public string $title;

    public string $shortDescription;

    public string $description;

    public ?string $notes;

    public ?DateTime $createdAt;

    public ?DateTime $updateAt;
}

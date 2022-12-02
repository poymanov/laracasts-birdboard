<?php

namespace App\Services\Project\Dtos;

class ProjectCreateDto
{
    public string $title;

    public string $description;

    public int $ownerId;
}

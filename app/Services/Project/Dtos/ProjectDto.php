<?php

namespace App\Services\Project\Dtos;

use App\Services\User\Dtos\UserDto;
use DateTime;

class ProjectDto
{
    public string $id;

    public string $title;

    public string $shortDescription;

    public string $description;

    public ?string $notes;

    public UserDto $owner;

    public ?DateTime $createdAt;

    public ?DateTime $updateAt;
}

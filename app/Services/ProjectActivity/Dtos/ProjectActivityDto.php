<?php

namespace App\Services\ProjectActivity\Dtos;

use App\Services\Project\Dtos\ProjectDto;
use App\Services\User\Dtos\UserDto;

class ProjectActivityDto
{
    public string $id;

    public ?UserDto $user;

    public ?ProjectDto $project;

    public string $type;

    public ?string $oldValue = null;

    public ?string $newValue = null;

    public ?string $createdAtDiffForHumans = null;
}

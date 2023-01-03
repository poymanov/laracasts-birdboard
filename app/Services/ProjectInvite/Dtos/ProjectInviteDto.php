<?php

namespace App\Services\ProjectInvite\Dtos;

use App\Enums\ProjectInviteStatusEnum;
use App\Services\Project\Dtos\ProjectDto;
use App\Services\User\Dtos\UserDto;

class ProjectInviteDto
{
    public string $id;

    public string $uuid;

    public ProjectDto $project;

    public UserDto $user;

    public ProjectInviteStatusEnum $status;
}

<?php

namespace App\Services\ProjectMember\Dtos;

use App\Services\Project\Dtos\ProjectDto;
use App\Services\User\Dtos\UserDto;

class ProjectMemberDto
{
    public string $id;

    public ProjectDto $project;

    public UserDto $user;

    public string $inviteId;
}

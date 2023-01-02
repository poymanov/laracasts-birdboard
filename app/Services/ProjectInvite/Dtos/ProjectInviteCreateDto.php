<?php

namespace App\Services\ProjectInvite\Dtos;

use App\Enums\ProjectInviteStatusEnum;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectInviteCreateDto
{
    public Uuid $projectId;

    public int $userId;

    public ProjectInviteStatusEnum $status;
}

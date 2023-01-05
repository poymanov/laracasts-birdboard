<?php

namespace App\Services\ProjectMember\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectMemberCreateDto
{
    public int $userId;

    public Uuid $projectId;

    public Uuid $inviteId;
}

<?php

namespace App\Enums;

enum CacheKeysEnum: string
{
    case OWNER_PROJECTS = 'owner-projects-';

    case PROJECT_TASKS = 'project-tasks-';
}

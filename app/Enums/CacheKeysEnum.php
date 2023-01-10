<?php

namespace App\Enums;

enum CacheKeysEnum: string
{
    case USER_PROJECTS = 'user-projects-';

    case PROJECT_TASKS = 'project-tasks-';
}

<?php

namespace App\Enums;

enum ProjectActivityTypeEnum: string
{
    case CREATE_PROJECT = 'create_project';
    case UPDATE_PROJECT_TITLE = 'update_project_title';
    case UPDATE_PROJECT_DESCRIPTION = 'update_project_description';
    case UPDATE_PROJECT_NOTES = 'update_project_notes';
    case CREATE_TASK = 'create_task';
    case UPDATE_TASK = 'update_task';
    case COMPLETE_TASK = 'complete_task';
    case INCOMPLETE_TASK = 'incomplete_task';
    case NEW_MEMBER = 'new_member';
    case DELETE_MEMBER = 'delete_member';
}

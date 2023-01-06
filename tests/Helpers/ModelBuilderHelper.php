<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\ProjectBuilder;
use Tests\Helpers\ModelBuilder\ProjectInviteBuilder;
use Tests\Helpers\ModelBuilder\ProjectMemberBuilder;
use Tests\Helpers\ModelBuilder\TaskBuilder;
use Tests\Helpers\ModelBuilder\UserBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder          $user;
    public ProjectBuilder       $project;
    public TaskBuilder          $task;
    public ProjectInviteBuilder $projectInvite;
    public ProjectMemberBuilder $projectMember;

    private function __construct()
    {
        $this->user          = new UserBuilder();
        $this->project       = new ProjectBuilder();
        $this->task          = new TaskBuilder();
        $this->projectInvite = new ProjectInviteBuilder();
        $this->projectMember = new ProjectMemberBuilder();
    }

    /**
     * @return ModelBuilderHelper
     */
    public static function getInstance(): ModelBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

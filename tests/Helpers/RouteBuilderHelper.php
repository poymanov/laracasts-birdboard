<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\CommonBuilder;
use Tests\Helpers\RouteBuilder\ProfileInviteBuilder;
use Tests\Helpers\RouteBuilder\ProjectBuilder;
use Tests\Helpers\RouteBuilder\ProjectInviteBuilder;
use Tests\Helpers\RouteBuilder\ProjectMemberBuilder;
use Tests\Helpers\RouteBuilder\TaskBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public CommonBuilder        $common;
    public AuthBuilder          $auth;
    public ProjectBuilder       $project;
    public TaskBuilder          $task;
    public ProjectMemberBuilder $member;
    public ProjectInviteBuilder $invite;
    public ProfileInviteBuilder $profileInvite;

    private function __construct()
    {
        $this->common        = new CommonBuilder();
        $this->auth          = new AuthBuilder();
        $this->project       = new ProjectBuilder();
        $this->task          = new TaskBuilder();
        $this->member        = new ProjectMemberBuilder();
        $this->invite        = new ProjectInviteBuilder();
        $this->profileInvite = new ProfileInviteBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

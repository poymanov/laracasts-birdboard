<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\CommonBuilder;
use Tests\Helpers\RouteBuilder\ProjectBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public CommonBuilder  $common;
    public AuthBuilder    $auth;
    public ProjectBuilder $project;

    private function __construct()
    {
        $this->common  = new CommonBuilder();
        $this->auth    = new AuthBuilder();
        $this->project = new ProjectBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

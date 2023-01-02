<?php

namespace Tests\Helpers\RouteBuilder;

class ProjectMemberBuilder
{
    /**
     * @param string $projectId
     *
     * @return string
     */
    public function index(string $projectId): string
    {
        return '/projects/' . $projectId . '/members';
    }
}

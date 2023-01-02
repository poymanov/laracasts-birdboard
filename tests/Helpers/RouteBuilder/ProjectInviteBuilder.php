<?php

namespace Tests\Helpers\RouteBuilder;

class ProjectInviteBuilder
{
    /**
     * @param string $projectId
     *
     * @return string
     */
    public function store(string $projectId): string
    {
        return '/projects/' . $projectId . '/invitations';
    }
}

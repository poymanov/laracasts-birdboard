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

    /**
     * @param string $projectId
     * @param string $memberId
     *
     * @return string
     */
    public function delete(string $projectId, string $memberId): string
    {
        return '/projects/' . $projectId . '/members/' . $memberId;
    }
}

<?php

namespace Tests\Helpers\RouteBuilder;

class ProjectBuilder
{
    /**
     * @return string
     */
    public function store(): string
    {
        return '/projects';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function update(string $id): string
    {
        return '/projects/' . $id;
    }
}

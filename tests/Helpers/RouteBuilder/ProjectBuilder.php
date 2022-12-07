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

    /**
     * @param string $id
     *
     * @return string
     */
    public function delete(string $id): string
    {
        return '/projects/' . $id;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function show(string $id): string
    {
        return '/projects/' . $id;
    }
}

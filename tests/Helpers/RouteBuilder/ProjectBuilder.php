<?php

namespace Tests\Helpers\RouteBuilder;

class ProjectBuilder
{
    /**
     * @return string
     */
    public function create(): string
    {
        return '/projects/create';
    }

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

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function edit(string $id): string
    {
        return '/projects/' . $id . '/edit';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function updateNotes(string $id): string
    {
        return '/projects/' . $id . '/update-notes';
    }
}

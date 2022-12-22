<?php

namespace Tests\Helpers\RouteBuilder;

class TaskBuilder
{
    /**
     * @return string
     */
    public function store(): string
    {
        return '/tasks';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function update(string $id): string
    {
        return '/tasks/' . $id;
    }
}

<?php

namespace Tests\Helpers\RouteBuilder;

class ProfileInviteBuilder
{
    /**
     * @return string
     */
    public function index(): string
    {
        return '/profile/invitations';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function reject(string $id): string
    {
        return '/profile/invitations/' . $id . '/reject';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function accept(string $id): string
    {
        return '/profile/invitations/' . $id . '/accept';
    }
}

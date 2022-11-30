<?php

namespace Tests\Helpers\RouteBuilder;

class CommonBuilder
{
    public function home(): string
    {
        return '/';
    }

    public function dashboard(): string
    {
        return '/dashboard';
    }

    public function profile(): string
    {
        return '/profile';
    }
}

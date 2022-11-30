<?php

namespace Tests\Helpers\RouteBuilder;

class AuthBuilder
{
    /**
     * @return string
     */
    public function login(): string
    {
        return '/login';
    }

    /**
     * @return string
     */
    public function confirmPassword(): string
    {
        return '/confirm-password';
    }

    /**
     * @return string
     */
    public function forgotPassword(): string
    {
        return '/forgot-password';
    }

    /**
     * @return string
     */
    public function resetPassword(): string
    {
        return '/reset-password';
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return '/password';
    }

    /**
     * @return string
     */
    public function register(): string
    {
        return '/register';
    }

    /**
     * @return string
     */
    public function verifyEmail(): string
    {
        return '/verify-email';
    }
}

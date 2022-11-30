<?php

namespace Tests\Helpers;

class AuthHelper
{
    private static ?AuthHelper $instance = null;

    public ModelBuilderHelper $modelBuilder;

    /**
     * @param ModelBuilderHelper $modelBuilder
     */
    private function __construct(ModelBuilderHelper $modelBuilder)
    {
        $this->modelBuilder = $modelBuilder;
    }

    /**
     * @param ModelBuilderHelper $modelBuilder
     *
     * @return AuthHelper
     */
    public static function getInstance(ModelBuilderHelper $modelBuilder): AuthHelper
    {
        if (static::$instance === null) {
            static::$instance = new static($modelBuilder);
        }

        return static::$instance;
    }

    /**
     * @param null $user
     */
    public function signIn($user = null): void
    {
        $user = $user ?: $this->modelBuilder->user->create();
        test()->actingAs($user);
    }
}

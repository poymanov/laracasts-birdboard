<?php

namespace App\Providers;

use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Contracts\UserRepositoryContact;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Factories\UserDtoFactory;
use App\Services\User\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserDtoFactoryContract::class, UserDtoFactory::class);
        $this->app->singleton(UserRepositoryContact::class, UserRepository::class);
        $this->app->singleton(UserServiceContract::class, UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

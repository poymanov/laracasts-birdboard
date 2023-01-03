<?php

namespace App\Providers;

use App\Services\ProjectInvite\Contracts\ProjectInviteCreateDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Factories\ProjectInviteCreateDtoFactory;
use App\Services\ProjectInvite\Factories\ProjectInviteDtoFactory;
use App\Services\ProjectInvite\ProjectInviteService;
use App\Services\ProjectInvite\Repositories\ProjectInviteRepository;
use Illuminate\Support\ServiceProvider;

class ProjectInviteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProjectInviteServiceContract::class, ProjectInviteService::class);
        $this->app->singleton(ProjectInviteRepositoryContract::class, ProjectInviteRepository::class);
        $this->app->singleton(ProjectInviteCreateDtoFactoryContract::class, ProjectInviteCreateDtoFactory::class);
        $this->app->singleton(ProjectInviteDtoFactoryContract::class, ProjectInviteDtoFactory::class);
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

<?php

namespace App\Providers;

use App\Enums\CacheTagsEnum;
use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteCreateDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteDtoFactoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteRepositoryContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Factories\ProjectInviteCreateDtoFactory;
use App\Services\ProjectInvite\Factories\ProjectInviteDtoFactory;
use App\Services\ProjectInvite\ProjectInviteService;
use App\Services\ProjectInvite\Repositories\ProjectInviteRepository;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Factories\ProjectMemberCreateDtoFactory;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Cache\Repository;
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
        $this->app->singleton(ProjectInviteRepositoryContract::class, ProjectInviteRepository::class);
        $this->app->singleton(ProjectInviteCreateDtoFactoryContract::class, ProjectInviteCreateDtoFactory::class);
        $this->app->singleton(ProjectInviteDtoFactoryContract::class, ProjectInviteDtoFactory::class);

        $this->app->singleton(ProjectInviteServiceContract::class, function () {
            return new ProjectInviteService(
                $this->app->make(ProjectServiceContract::class),
                $this->app->make(UserServiceContract::class),
                $this->app->make(ProjectInviteRepositoryContract::class),
                $this->app->make(ProjectInviteCreateDtoFactory::class),
                $this->app->make(ProjectMemberCreateDtoFactory::class),
                $this->app->make(ProjectMemberServiceContract::class),
                $this->app->make(NotificationServiceContract::class),
                $this->app->make(Repository::class),
                [CacheTagsEnum::PROJECTS->value],
            );
        });
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

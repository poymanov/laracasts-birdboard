<?php

namespace App\Providers;

use App\Enums\CacheTagsEnum;
use App\Services\Notification\Contracts\NotificationServiceContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\ProjectMember\Contracts\ProjectMemberCreateDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Factories\ProjectMemberCreateDtoFactory;
use App\Services\ProjectMember\Factories\ProjectMemberDtoFactory;
use App\Services\ProjectMember\ProjectMemberService;
use App\Services\ProjectMember\Repositories\ProjectMemberRepository;
use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;

class ProjectMemberServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProjectMemberRepositoryContract::class, ProjectMemberRepository::class);
        $this->app->singleton(ProjectMemberCreateDtoFactoryContract::class, ProjectMemberCreateDtoFactory::class);
        $this->app->singleton(ProjectMemberDtoFactoryContract::class, ProjectMemberDtoFactory::class);

        $this->app->singleton(ProjectMemberServiceContract::class, function () {
            return new ProjectMemberService(
                $this->app->make(ProjectMemberRepositoryContract::class),
                $this->app->make(ProjectServiceContract::class),
                $this->app->make(NotificationServiceContract::class),
                $this->app->make(ProjectActivityServiceContract::class),
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

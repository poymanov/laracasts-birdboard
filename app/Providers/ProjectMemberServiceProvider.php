<?php

namespace App\Providers;

use App\Services\ProjectMember\Contracts\ProjectMemberCreateDtoFactoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberRepositoryContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Factories\ProjectMemberCreateDtoFactory;
use App\Services\ProjectMember\ProjectMemberService;
use App\Services\ProjectMember\Repositories\ProjectMemberRepository;
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
        $this->app->singleton(ProjectMemberServiceContract::class, ProjectMemberService::class);
        $this->app->singleton(ProjectMemberRepositoryContract::class, ProjectMemberRepository::class);
        $this->app->singleton(ProjectMemberCreateDtoFactoryContract::class, ProjectMemberCreateDtoFactory::class);
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

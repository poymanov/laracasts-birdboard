<?php

namespace App\Providers;

use App\Services\Project\Contracts\ProjectCreateDtoFactoryContract;
use App\Services\Project\Contracts\ProjectDtoFactoryContract;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Contracts\ProjectUpdateDtoFactoryContract;
use App\Services\Project\Factories\ProjectCreateDtoFactory;
use App\Services\Project\Factories\ProjectDtoFactory;
use App\Services\Project\Factories\ProjectUpdateDtoFactory;
use App\Services\Project\ProjectService;
use App\Services\Project\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProjectCreateDtoFactoryContract::class, ProjectCreateDtoFactory::class);
        $this->app->singleton(ProjectUpdateDtoFactoryContract::class, ProjectUpdateDtoFactory::class);
        $this->app->singleton(ProjectDtoFactoryContract::class, ProjectDtoFactory::class);
        $this->app->singleton(ProjectRepositoryContract::class, ProjectRepository::class);
        $this->app->singleton(ProjectServiceContract::class, ProjectService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

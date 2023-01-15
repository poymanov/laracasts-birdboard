<?php

namespace App\Providers;

use App\Services\ProjectActivity\Contracts\ProjectActivityCreateDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityRepositoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\ProjectActivity\Factories\ProjectActivityCreateDtoFactory;
use App\Services\ProjectActivity\Factories\ProjectActivityDtoFactory;
use App\Services\ProjectActivity\ProjectActivityService;
use App\Services\ProjectActivity\Repositories\ProjectActivityRepository;
use Illuminate\Support\ServiceProvider;

class ProjectActivityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProjectActivityCreateDtoFactoryContract::class, ProjectActivityCreateDtoFactory::class);
        $this->app->singleton(ProjectActivityRepositoryContract::class, ProjectActivityRepository::class);
        $this->app->singleton(ProjectActivityDtoFactoryContract::class, ProjectActivityDtoFactory::class);

        $activitiesLimit = config('project.activities_limit');

        $this->app->singleton(
            ProjectActivityServiceContract::class,
            fn () => new ProjectActivityService(
                $this->app->make(ProjectActivityCreateDtoFactoryContract::class),
                $this->app->make(ProjectActivityRepositoryContract::class),
                $activitiesLimit
            )
        );
    }
}

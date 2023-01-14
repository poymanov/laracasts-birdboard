<?php

namespace App\Providers;

use App\Services\ProjectActivity\Contracts\ProjectActivityCreateDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityRepositoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\ProjectActivity\Factories\ProjectActivityCreateDtoFactory;
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
        $this->app->singleton(ProjectActivityServiceContract::class, ProjectActivityService::class);
    }
}

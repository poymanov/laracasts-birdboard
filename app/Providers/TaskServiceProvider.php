<?php

namespace App\Providers;

use App\Services\Task\Contracts\TaskCreateDtoFactoryContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Contracts\TaskUpdateDtoFactoryContract;
use App\Services\Task\Factories\TaskCreateDtoFactory;
use App\Services\Task\Factories\TaskUpdateDtoFactory;
use App\Services\Task\Repositories\TaskRepository;
use App\Services\Task\TaskService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TaskRepositoryContract::class, TaskRepository::class);
        $this->app->singleton(TaskCreateDtoFactoryContract::class, TaskCreateDtoFactory::class);
        $this->app->singleton(TaskUpdateDtoFactoryContract::class, TaskUpdateDtoFactory::class);
        $this->app->singleton(TaskServiceContract::class, TaskService::class);
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

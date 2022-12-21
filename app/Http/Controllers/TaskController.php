<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Services\Task\Contracts\TaskCreateDtoFactoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskServiceContract $taskService,
        private readonly TaskCreateDtoFactoryContract $taskCreateDtoFactory
    ) {
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $projectId = Uuid::make($request->get('project_id'));
            $body      = $request->get('body');

            $taskCreateDto = $this->taskCreateDtoFactory->createFromParams($projectId, $body);

            $this->taskService->create($taskCreateDto);

            return redirect()->route('projects.show', $projectId->value())->with('alert.success', 'Task was created');
        } catch (TaskCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }
}

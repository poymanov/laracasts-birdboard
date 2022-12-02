<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectServiceContract $projectService)
    {
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->projectService->create($request->get('title'), $request->get('description'), (int)auth()->id());

            return redirect()->route('dashboard')->with('alert.success', 'Task was created');
        } catch (ProjectCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Services\Project\Contracts\ProjectCreateDtoFactoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Contracts\ProjectUpdateDtoFactoryContract;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\Project\Exceptions\ProjectUpdateFailedException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly ProjectCreateDtoFactoryContract $projectCreateDtoFactoryContract,
        private readonly ProjectUpdateDtoFactoryContract $projectUpdateDtoFactoryContract
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
            $projectCreateDto = $this->projectCreateDtoFactoryContract->createFromParams(
                $request->get('title'),
                $request->get('description'),
                (int)auth()->id()
            );

            $this->projectService->create($projectCreateDto);

            return redirect()->route('dashboard')->with('alert.success', 'Project was created');
        } catch (ProjectCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param string        $id
     * @param UpdateRequest $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, UpdateRequest $request)
    {
        $projectId = Uuid::make($id);

        $this->checkBelongsToUser($projectId);

        try {
            $projectUpdateDto = $this->projectUpdateDtoFactoryContract->createFromParams($request->get('title'), $request->get('description'));

            $this->projectService->update($projectId, $projectUpdateDto);

            return redirect()->route('dashboard')->with('alert.success', 'Project was updated');
        } catch (ProjectNotFoundException) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (ProjectUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Uuid $projectId
     *
     * @return void
     */
    private function checkBelongsToUser(Uuid $projectId): void
    {
        if (!$this->projectService->isBelongsToUser((int)auth()->id(), $projectId)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}

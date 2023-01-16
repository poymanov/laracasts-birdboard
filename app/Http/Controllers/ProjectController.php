<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateNotesRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Services\Project\Contracts\ProjectCreateDtoFactoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Contracts\ProjectUpdateDtoFactoryContract;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use App\Services\Project\Exceptions\ProjectDeleteFailedException;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\Project\Exceptions\ProjectUpdateFailedException;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\Task\Contracts\TaskServiceContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly TaskServiceContract $taskService,
        private readonly ProjectCreateDtoFactoryContract $projectCreateDtoFactoryContract,
        private readonly ProjectUpdateDtoFactoryContract $projectUpdateDtoFactoryContract,
        private readonly ProjectMemberServiceContract $projectMemberService,
        private readonly ProjectActivityServiceContract $projectActivityService
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
     * @param string $id
     *
     * @return RedirectResponse|\Inertia\Response
     */
    public function edit(string $id)
    {
        $projectId = Uuid::make($id);

        $this->checkBelongsToUser($projectId);

        try {
            $project = $this->projectService->findOneById($projectId);

            return Inertia::render('Project/Edit', compact('project'));
        } catch (ProjectNotFoundException $e) {
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

            $this->projectService->update($projectId, (int)auth()->id(), $projectUpdateDto);

            return redirect()->route('projects.show', $id)->with('alert.success', 'Project was updated');
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
     * @param string $id
     *
     * @return RedirectResponse|void
     */
    public function destroy(string $id)
    {
        $projectId = Uuid::make($id);

        $this->checkBelongsToUser($projectId);

        try {
            $this->projectService->delete($projectId);

            return redirect()->route('dashboard')->with('alert.success', 'Project was deleted');
        } catch (ProjectNotFoundException) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (ProjectDeleteFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Project/Create');
    }

    /**
     * @param string $id
     *
     * @return RedirectResponse|\Inertia\Response|void
     */
    public function show(string $id)
    {
        $currentUserId = (int)auth()->id();

        $projectId = Uuid::make($id);

        $isMember = $this->projectMemberService->isProjectMember($currentUserId, $projectId);
        $isOwner  = $this->projectService->isBelongsToUser($currentUserId, $projectId);

        $this->checkUserHaveAccessToProject($isOwner, $isMember);

        try {
            $project    = $this->projectService->findOneById($projectId);
            $tasks      = $this->taskService->findAllByProjectId($projectId);
            $activities = $this->projectActivityService->findAllByProjectId($projectId);
            $members    = $this->projectMemberService->findAllByProjectId($projectId);

            return Inertia::render(
                'Project/Show',
                compact('project', 'tasks', 'isOwner', 'activities', 'members')
            );
        } catch (ProjectNotFoundException) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param string             $id
     * @param UpdateNotesRequest $request
     *
     * @return RedirectResponse
     */
    public function updateNotes(string $id, UpdateNotesRequest $request)
    {
        $projectId = Uuid::make($id);

        $currentUserId = (int)auth()->id();

        $isMember = $this->projectMemberService->isProjectMember($currentUserId, $projectId);
        $isOwner  = $this->projectService->isBelongsToUser($currentUserId, $projectId);

        $this->checkUserHaveAccessToProject($isOwner, $isMember);

        try {
            $this->projectService->updateNotes($projectId, (int)auth()->id(), $request->get('notes'));

            return redirect()->route('projects.show', $projectId)->with('alert.success', 'Project notes was updated');
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

    /**
     * @param bool $isOwner
     * @param bool $isMember
     *
     * @return void
     */
    private function checkUserHaveAccessToProject(bool $isOwner, bool $isMember): void
    {
        if (!$isMember && !$isOwner) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}

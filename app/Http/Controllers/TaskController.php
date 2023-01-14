<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\Task\Contracts\TaskCreateDtoFactoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Contracts\TaskUpdateDtoFactoryContract;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotBelongsToProject;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskServiceContract $taskService,
        private readonly TaskCreateDtoFactoryContract $taskCreateDtoFactory,
        private readonly TaskUpdateDtoFactoryContract $taskUpdateDtoFactory,
        private readonly ProjectServiceContract $projectService,
        private readonly ProjectMemberServiceContract $projectMemberService
    ) {
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $projectId     = Uuid::make($request->get('project_id'));
        $currentUserId = (int)auth()->id();

        $isMember = $this->projectMemberService->isProjectMember($currentUserId, $projectId);
        $isOwner  = $this->projectService->isBelongsToUser($currentUserId, $projectId);

        if (!$isMember && !$isOwner) {
            abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $body = $request->get('body');

            $taskCreateDto = $this->taskCreateDtoFactory->createFromParams($projectId, $body);

            $this->taskService->create((int)auth()->id(), $taskCreateDto);

            return redirect()->route('projects.show', $projectId->value())->with('alert.success', 'Task was created');
        } catch (TaskCreateFailedException $e) {
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, UpdateRequest $request)
    {
        $projectId = Uuid::make($request->get('project_id'));
        $taskId    = Uuid::make($id);

        $currentUserId = (int)auth()->id();

        $isMember = $this->projectMemberService->isProjectMember($currentUserId, $projectId);
        $isOwner  = $this->projectService->isBelongsToUser($currentUserId, $projectId);

        $this->checkUserHaveAccessToProject($isOwner, $isMember);

        try {
            $body      = $request->get('body');
            $completed = $request->get('completed');

            $taskUpdateDto = $this->taskUpdateDtoFactory->createFromParams($body, $completed, $projectId);

            $this->taskService->update($taskId, (int)auth()->id(), $taskUpdateDto);

            return redirect()->route('projects.show', $projectId)->with('alert.success', 'Task was updated');
        } catch (TaskNotBelongsToProject $e) {
            Log::error($e);

            abort(Response::HTTP_FORBIDDEN);
        } catch (TaskUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
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

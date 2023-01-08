<?php

namespace App\Http\Controllers;

use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\ProjectMember\Contracts\ProjectMemberServiceContract;
use App\Services\ProjectMember\Exceptions\ProjectMemberWrongMemberException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectMemberController extends Controller
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly ProjectMemberServiceContract $projectMemberService
    ) {
    }

    /**
     * @param string $projectId
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function index(string $projectId)
    {
        $projectId = Uuid::make($projectId);
        $this->checkProjectBelongsToUser($projectId);

        try {
            $project = $this->projectService->findOneById($projectId);
            $members = $this->projectMemberService->findAllByProjectId($projectId);

            return Inertia::render('Member/Index', compact('project', 'members'));
        } catch (ProjectNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param string $projectId
     * @param string $projectMemberId
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(string $projectId, string $projectMemberId)
    {
        $projectId       = Uuid::make($projectId);
        $projectMemberId = Uuid::make($projectMemberId);

        $this->checkProjectBelongsToUser($projectId);

        try {
            $this->projectMemberService->delete($projectId, $projectMemberId);

            return redirect()->route('projects.members.index', $projectId)->with('alert.success', 'Project member was deleted');
        } catch (ProjectNotFoundException) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (ProjectMemberWrongMemberException) {
            abort(Response::HTTP_FORBIDDEN);
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('projects.members.index', $projectId)->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Uuid $projectId
     *
     * @return void
     */
    private function checkProjectBelongsToUser(Uuid $projectId): void
    {
        if (!$this->projectService->isBelongsToUser((int)auth()->id(), $projectId)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}

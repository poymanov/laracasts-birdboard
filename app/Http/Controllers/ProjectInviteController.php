<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvite\StoreRequest;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteSelfCreateException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectInviteController extends Controller
{
    public function __construct(
        private readonly ProjectServiceContract $projectService,
        private readonly ProjectInviteServiceContract $projectInviteService
    ) {
    }

    /**
     * @param string       $id
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException
     * @throws \App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException
     * @throws \App\Services\ProjectInvite\Exceptions\ProjectInviteSelfCreateException
     * @throws \App\Services\Project\Exceptions\ProjectNotFoundException
     * @throws \App\Services\User\Exceptions\UserNotFoundByEmailException
     */
    public function store(string $id, StoreRequest $request)
    {
        $projectId = Uuid::make($id);
        $this->checkProjectBelongsToUser($projectId);

        try {
            $email = Email::make($request->get('email'));

            $this->projectInviteService->create($projectId, $email);

            return redirect()->route('projects.members.index', $id)->with('alert.success', 'User was invited');
        } catch (ProjectInviteSelfCreateException|ProjectInviteCreateFailedException|ProjectInviteAlreadyException $e) {
            return redirect()->route('projects.members.index', $id)->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('projects.members.index', $id)->with('alert.error', 'Something went wrong');
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

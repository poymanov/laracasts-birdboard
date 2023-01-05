<?php

namespace App\Http\Controllers;

use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAcceptAnotherUserException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAcceptWrongStatusException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteNotFoundException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectAnotherUserException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteRejectWrongStatusException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteUpdateStatusFailedException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProfileInviteController extends Controller
{
    public function __construct(private readonly ProjectInviteServiceContract $projectInviteService)
    {
    }

    /**
     * @return \Inertia\Response
     * @throws \Exception
     */
    public function index()
    {
        $invitations = $this->projectInviteService->findAllSentByUserId((int) auth()->id());

        return Inertia::render('Profile/Invite/Index', ['invitations' => $invitations]);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function reject(string $id)
    {
        $id = Uuid::make($id);

        try {
            $this->projectInviteService->reject($id, (int) auth()->id());

            return redirect()->route('profile.invitations.index')->with('alert.success', 'Invite was rejected');
        } catch (ProjectInviteRejectAnotherUserException|ProjectInviteRejectWrongStatusException) {
            abort(Response::HTTP_FORBIDDEN);
        } catch (ProjectInviteNotFoundException|ProjectInviteUpdateStatusFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('profile.invitations.index')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function accept(string $id)
    {
        $id = Uuid::make($id);

        try {
            $this->projectInviteService->accept($id, (int) auth()->id());

            return redirect()->route('profile.invitations.index')->with('alert.success', 'Invite was accepted');
        } catch (ProjectInviteAcceptAnotherUserException|ProjectInviteAcceptWrongStatusException) {
            abort(Response::HTTP_FORBIDDEN);
        } catch (ProjectInviteNotFoundException|ProjectInviteUpdateStatusFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('profile.invitations.index')->with('alert.error', 'Something went wrong');
        }
    }
}

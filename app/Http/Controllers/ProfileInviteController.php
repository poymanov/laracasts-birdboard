<?php

namespace App\Http\Controllers;

use App\Services\ProjectInvite\Contracts\ProjectInviteServiceContract;
use Inertia\Inertia;

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
}

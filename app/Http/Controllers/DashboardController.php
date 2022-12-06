<?php

namespace App\Http\Controllers;

use App\Services\Project\Contracts\ProjectServiceContract;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private readonly ProjectServiceContract $projectService)
    {
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $projects = $this->projectService->findAllByOwnerId((int) auth()->id());

        return Inertia::render('Dashboard', compact('projects'));
    }
}

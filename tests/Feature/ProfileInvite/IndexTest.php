<?php

use App\Enums\ProjectInviteStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Просмотр для гостя запрещен */
test('guest', function () {
    $this
        ->get(routeBuilderHelper()->profileInvite->index())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Просмотр списка приглашений */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();

    modelBuilderHelper()->projectInvite->create([
        'project_id' => $project->id,
        'user_id'    => $user->id,
        'status'     => ProjectInviteStatusEnum::SENT->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->profileInvite->index())->assertInertia(
            fn (Assert $page) => $page->component('Profile/Invite/Index')
                ->has('invitations', 1)
                ->where('invitations.0.project.title', $project->title)
                ->where('invitations.0.project.description', $project->description)
        );
});

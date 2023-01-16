<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Просмотр для гостя запрещен */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this
        ->get(routeBuilderHelper()->project->show($project->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Успешный просмотр */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))
        ->assertInertia(fn (Assert $page) => $page->where('project.title', $project->title)
            ->where('project.notes', $project->notes)->has('tasks', 0));
});

/** Просмотр с задачами */
test('with tasks', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    $firstTask  = modelBuilderHelper()->task->create(['project_id' => $project->id]);
    $secondTask = modelBuilderHelper()->task->create(['project_id' => $project->id]);

    authHelper()->signIn($user);

    $this->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
        fn (Assert $page) => $page->has('tasks', 2)
            ->where('tasks.0.id', $firstTask->id)
            ->where('tasks.0.body', $firstTask->body)
            ->where('tasks.1.id', $secondTask->id)
            ->where('tasks.1.body', $secondTask->body)
    );
});

/** Просмотр с участниками */
test('with members', function () {
    $user       = modelBuilderHelper()->user->create();
    $userMember = modelBuilderHelper()->user->create(['email' => 'test@test.ru']);
    $project    = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    modelBuilderHelper()->projectMember->create(['project_id' => $project->id, 'user_id' => $userMember->id]);

    authHelper()->signIn($user);

    $this->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
        fn (Assert $page) => $page->has('members', 1)
            ->where('members.0.user.gravatarUrl', 'https://gravatar.com/avatar/cbc4c5829ca103f23a20b31dbf953d05?s=60')
    );
});

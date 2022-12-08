<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Редактирование для гостя запрещено */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this
        ->get(routeBuilderHelper()->project->edit($project->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Редактирование чужого проекта запрещено */
test('another owner', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->project->edit($project->id))
        ->assertForbidden();
});

/** Успешное открытие страницы редактирования */
test('success', function () {
    $user = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this->get(routeBuilderHelper()->project->edit($project->id))->assertOk()->assertInertia(
        fn (Assert $page) => $page->component('Project/Edit')
            ->where('project.title', $project->title)
            ->where('project.description', $project->description)
    );
});

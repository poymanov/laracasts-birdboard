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
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->project->show($project->id))
        ->assertInertia(fn (Assert $page) => $page->where('project.title', $project->title)->where('project.notes', $project->notes));
});

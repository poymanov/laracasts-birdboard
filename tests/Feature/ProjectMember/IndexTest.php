<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Просмотр для гостя */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();
    $this
        ->get(routeBuilderHelper()->member->index($project->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Просмотр чужого проекта */
test('not project owner', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->member->index($project->id))
        ->assertForbidden();
});

/** Несуществующий проект */
test('not exists', function () {
    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->member->index(faker()->uuid))
        ->assertForbidden();
});

/** Успешный просмотр */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->member->index($project->id))
        ->assertInertia(fn (Assert $page) => $page->where('project.title', $project->title));
});

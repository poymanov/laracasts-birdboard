<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this->patch(routeBuilderHelper()->project->update($project->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения чужого проекта */
test('another user', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $updateProjectData = modelBuilderHelper()->project->make();

    $this->patch(routeBuilderHelper()->project->update($project->id), $updateProjectData->toArray())
        ->assertForbidden();
});

/** Попытка изменения со слишком коротким заголовком */
test('too short title', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->project->update($project->id), ['title' => 'te'])->assertSessionHasErrors(['title']);
});

/** Попытка создания со слишком длинными заголовком */
test('too long title', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->project->update($project->id), ['title' => faker()->sentence(256)])->assertSessionHasErrors(['title']);
});

/**
 * Ошибка изменения
 */
test('failed', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $updateProjectData = modelBuilderHelper()->project->make();

    Project::saving(fn () => false);

    $this
        ->from(routeBuilderHelper()->common->dashboard())
        ->patch(routeBuilderHelper()->project->update($project->id), $updateProjectData->toArray())
        ->assertSessionHas('alert.error')
        ->assertRedirect(routeBuilderHelper()->common->dashboard());

    $this->assertDatabaseMissing('projects', [
        'title'       => $updateProjectData->title,
        'description' => $updateProjectData->description,
    ]);
});

/** Успешное изменение */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $updateProjectData = modelBuilderHelper()->project->make();

    $response = $this
        ->from(routeBuilderHelper()->common->dashboard())
        ->patch(routeBuilderHelper()->project->update($project->id), $updateProjectData->toArray());
    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('projects', [
        'title'       => $updateProjectData->title,
        'description' => $updateProjectData->description,
    ]);
});

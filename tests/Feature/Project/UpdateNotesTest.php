<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this->patch(routeBuilderHelper()->project->updateNotes($project->id), ['notes' => faker()->word()])
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения чужого проекта */
test('another user', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this->patch(routeBuilderHelper()->project->updateNotes($project->id), ['notes' => faker()->word()])->assertForbidden();
});

/** Попытка изменения без данных */
test('empty', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->project->updateNotes($project->id))->assertSessionHasErrors(['notes']);
});

/** Успешное изменение */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    $updateProjectData = modelBuilderHelper()->project->make();

    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->project->updateNotes($project->id), ['notes' => $updateProjectData->notes]);
    $response->assertSessionHasNoErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('projects', [
        'id'    => $project->id,
        'notes' => $updateProjectData->notes,
    ]);

    $this->assertDatabaseCount('project_activities', 1);

    $this->assertDatabaseHas('project_activities', [
        'user_id'    => $user->id,
        'project_id' => $project->id,
        'type'       => 'update_project_notes',
        'old_value'  => $project->notes,
        'new_value'  => $updateProjectData->notes,
    ]);
});

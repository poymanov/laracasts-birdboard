<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this
        ->delete(routeBuilderHelper()->project->delete($project->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления чужого проекта */
test('another user', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this
        ->delete(routeBuilderHelper()->project->delete($project->id))
        ->assertForbidden();
});

/** Ошибка удаления проекта */
test('failed', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    Project::deleting(fn () => false);

    $this
        ->from(routeBuilderHelper()->common->dashboard())
        ->delete(routeBuilderHelper()->project->delete($project->id))
        ->assertSessionHas('alert.error')
        ->assertRedirect(routeBuilderHelper()->common->dashboard());

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
    ]);
});

/** Успешное удаление проекта */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this
        ->from(routeBuilderHelper()->common->dashboard())
        ->delete(routeBuilderHelper()->project->delete($project->id))
        ->assertSessionDoesntHaveErrors()
        ->assertSessionHas('alert.success')
        ->assertRedirect(routeBuilderHelper()->common->dashboard());

    $this->assertDatabaseMissing('projects', [
        'id'         => $project->id,
        'deleted_at' => null,
    ]);
});

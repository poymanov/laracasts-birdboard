<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    $this->patch(routeBuilderHelper()->task->update($task->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения со слишком коротким содержимым */
test('too short body', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $this->patch(routeBuilderHelper()->task->update($task->id), ['body' => 'te'])->assertSessionHasErrors(['body']);
});

/** Попытка изменения для чужого проекта */
test('another user project', function () {
    $task    = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $this->patch(routeBuilderHelper()->task->update($task->id), $task->toArray())->assertForbidden();
});

/** Попытка изменения задачи принадлежащей другому проекта */
test('another project', function () {
    $user = modelBuilderHelper()->user->create();

    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $task    = modelBuilderHelper()->task->create();

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->task->update($task->id), $task->toArray())->assertForbidden();
});

/** Успешное изменение задачи */
test('success', function () {
    $user       = modelBuilderHelper()->user->create();
    $project    = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $task       = modelBuilderHelper()->task->create(['project_id' => $project->id]);
    $updateTask = modelBuilderHelper()->task->make(['project_id' => $project->id]);

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->task->update($task->id), $updateTask->toArray())
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'id'         => $task->id,
        'project_id' => $project->id,
        'body'       => $updateTask->body,
        'completed'  => $updateTask->completed,
    ]);
});

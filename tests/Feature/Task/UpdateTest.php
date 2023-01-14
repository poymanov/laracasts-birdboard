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
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $this->patch(routeBuilderHelper()->task->update($task->id), $task->toArray())->assertForbidden();
});

/** Попытка изменения задачи принадлежащей другому проекта */
test('another project', function () {
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn($user);

    $this->patch(routeBuilderHelper()->task->update($task->id), $task->toArray())->assertForbidden();
});

/** Успешное изменение текста задач */
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

    $this->assertDatabaseCount('project_activities', 1);

    $this->assertDatabaseHas('project_activities', [
        'user_id'    => $user->id,
        'project_id' => $project->id,
        'type'       => 'update_task',
        'old_value'  => $task->body,
        'new_value'  => $updateTask->body,
    ]);
});

/** Успешное завершение задачи */
test('success complete', function () {
    $user       = modelBuilderHelper()->user->create();
    $project    = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $task       = modelBuilderHelper()->task->create(['project_id' => $project->id, 'completed' => false]);
    $updateTask = modelBuilderHelper()->task->make(['project_id' => $project->id, 'body' => $task->body, 'completed' => true]);

    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->task->update($task->id), $updateTask->toArray());
    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'id'         => $task->id,
        'project_id' => $project->id,
        'completed'  => $updateTask->completed,
    ]);

    $this->assertDatabaseCount('project_activities', 1);

    $this->assertDatabaseHas('project_activities', [
        'user_id'    => $user->id,
        'project_id' => $project->id,
        'type'       => 'complete_task',
    ]);
});

/** Успешная отмена завершения задачи */
test('success incomplete', function () {
    $user       = modelBuilderHelper()->user->create();
    $project    = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $task       = modelBuilderHelper()->task->create(['project_id' => $project->id, 'completed' => true]);
    $updateTask = modelBuilderHelper()->task->make(['project_id' => $project->id, 'body' => $task->body, 'completed' => false]);

    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->task->update($task->id), $updateTask->toArray());
    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'id'         => $task->id,
        'project_id' => $project->id,
        'completed'  => $updateTask->completed,
    ]);

    $this->assertDatabaseCount('project_activities', 1);

    $this->assertDatabaseHas('project_activities', [
        'user_id'    => $user->id,
        'project_id' => $project->id,
        'type'       => 'incomplete_task',
    ]);
});

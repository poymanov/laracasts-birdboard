<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Успешное создание участником проекта */
test('success store', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();
    modelBuilderHelper()->projectMember->create(['user_id' => $user->id, 'project_id' => $project->id]);

    $taskData = modelBuilderHelper()->task->make(['project_id' => $project->id]);

    authHelper()->signIn($user);

    $response = $this->post(routeBuilderHelper()->task->store(), $taskData->toArray());
    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'project_id' => $project->id,
        'body'       => $taskData->body,
    ]);
});

/** Успешное изменение участником проекта */
test('success update', function () {
    $user       = modelBuilderHelper()->user->create();
    $project    = modelBuilderHelper()->project->create();
    $task       = modelBuilderHelper()->task->create(['project_id' => $project->id]);
    $updateTask = modelBuilderHelper()->task->make(['project_id' => $project->id]);
    modelBuilderHelper()->projectMember->create(['user_id' => $user->id, 'project_id' => $project->id]);

    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->task->update($task->id), $updateTask->toArray());
    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'id'         => $task->id,
        'project_id' => $project->id,
        'body'       => $updateTask->body,
        'completed'  => $updateTask->completed,
    ]);
});

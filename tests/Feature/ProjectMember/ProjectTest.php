<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Успешный просмотр */
test('success show', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();
    modelBuilderHelper()->projectMember->create(['user_id' => $user->id, 'project_id' => $project->id]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(fn (Assert $page) => $page->where(
            'project.title',
            $project->title
        )
            ->where('project.notes', $project->notes)->has('tasks', 0));
});

/** Успешный просмотр с задачами */
test('success show with tasks', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();
    modelBuilderHelper()->projectMember->create(['user_id' => $user->id, 'project_id' => $project->id]);

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

/** Успешное изменение заметок проекта */
test('success update notes', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();
    modelBuilderHelper()->projectMember->create(['user_id' => $user->id, 'project_id' => $project->id]);

    $updateProjectData = modelBuilderHelper()->project->make();

    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->project->updateNotes($project->id), ['notes' => $updateProjectData->notes]);
    $response->assertSessionHasNoErrors();
    $response->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('projects', [
        'id'    => $project->id,
        'notes' => $updateProjectData->notes,
    ]);
});

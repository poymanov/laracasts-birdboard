<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $this->post(routeBuilderHelper()->task->store())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания без данных */
test('empty', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->task->store())->assertSessionHasErrors(['body', 'project_id']);
});

/** Попытка создания со слишком коротким заголовком */
test('too short title', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->task->store(), ['body' => 'te'])->assertSessionHasErrors(['body']);
});

/** Попытка создания для несуществующего проекта */
test('not existed project', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->task->store(), ['project_id' => faker()->uuid])->assertSessionHasErrors(['project_id']);
});

/** Успешное создание */
test('success', function () {
    authHelper()->signIn();

    $project  = modelBuilderHelper()->project->create();
    $taskData = modelBuilderHelper()->task->make(['project_id' => $project->id]);

    $this
        ->post(routeBuilderHelper()->task->store(), $taskData->toArray())
        ->assertSessionDoesntHaveErrors()->assertRedirect(routeBuilderHelper()->project->show($project->id));

    $this->assertDatabaseHas('tasks', [
        'project_id' => $project->id,
        'body'       => $taskData->body,
    ]);
});

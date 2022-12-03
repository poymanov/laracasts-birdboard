<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $this->post(routeBuilderHelper()->project->store())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания без данных */
test('empty', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->project->store())->assertSessionHasErrors(['title', 'description']);
});

/** Попытка создания со слишком коротким заголовком */
test('too short title', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->project->store(), ['title' => 'te'])->assertSessionHasErrors(['title']);
});

/** Попытка создания со слишком длинными заголовком */
test('too long title', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->project->store(), ['title' => faker()->sentence(256)])->assertSessionHasErrors(['title']);
});

/** Ошибка создания */
test('failed', function () {
    authHelper()->signIn();

    $projectData = modelBuilderHelper()->project->make();

    Project::saving(fn () => false);

    $this
        ->from(routeBuilderHelper()->common->dashboard())
        ->post(routeBuilderHelper()->project->store(), $projectData->toArray())
        ->assertSessionHas('alert.error')
        ->assertRedirect(routeBuilderHelper()->common->dashboard());

    $this->assertDatabaseMissing('projects', [
        'title'       => $projectData->title,
        'description' => $projectData->description,
    ]);
});

/** Успешное создание */
test('success', function () {
    authHelper()->signIn();

    $projectData = modelBuilderHelper()->project->make();

    $this->post(routeBuilderHelper()->project->store(), $projectData->toArray())
        ->assertSessionDoesntHaveErrors()
        ->assertSessionHas('alert.success')
        ->assertRedirect(routeBuilderHelper()->common->dashboard());

    $this->assertDatabaseHas('projects', [
        'title'       => $projectData->title,
        'description' => $projectData->description,
    ]);
});

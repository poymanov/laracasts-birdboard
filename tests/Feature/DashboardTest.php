<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Просмотр для гостя запрещен */
test('guest', function () {
    $this->get(routeBuilderHelper()->common->dashboard())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Отображение правильного компонента */
test('correct component', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->common->dashboard())
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Dashboard'));
});

/** Без проектов */
test('empty projects list', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->common->dashboard())->assertInertia(fn (Assert $page) => $page->has('projects', 0));
});

/** С одним проектом в списке */
test('with one project', function () {
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    $firstProject  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    $this->get(routeBuilderHelper()->common->dashboard())->assertInertia(
        fn (Assert $page) => $page->has('projects', 1)
            ->where('projects.0.id', $firstProject->id)
            ->where('projects.0.title', $firstProject->title)
            ->where('projects.0.shortDescription', Str::limit($firstProject->description))
    );
});

/** Вывод с сортировкой: последние обновленные - первыми */
test('sort last updated', function () {
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    $firstProject  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $secondProject  = modelBuilderHelper()->project->create(['owner_id' => $user->id, 'updated_at' => Carbon::now()->addMinute()]);

    $this->get(routeBuilderHelper()->common->dashboard())->assertInertia(
        fn (Assert $page) => $page->has('projects', 2)
            ->where('projects.0.id', $secondProject->id)
            ->where('projects.0.title', $secondProject->title)
            ->where('projects.0.shortDescription', Str::limit($secondProject->description))
            ->where('projects.1.id', $firstProject->id)
            ->where('projects.1.title', $firstProject->title)
            ->where('projects.1.shortDescription', Str::limit($firstProject->description))
    );
});

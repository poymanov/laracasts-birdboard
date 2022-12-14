<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Создание для гостя запрещено */
test('guest', function () {
    $this
        ->get(routeBuilderHelper()->project->create())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Успешное открытие страницы создания */
test('success', function () {
    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->project->create())->assertOk()->assertInertia(
            fn (Assert $page) => $page->component('Project/Create')
        );
});

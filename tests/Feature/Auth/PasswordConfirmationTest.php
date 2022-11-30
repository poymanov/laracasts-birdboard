<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->auth->confirmPassword())->assertOk();
});

test('password can be confirmed', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

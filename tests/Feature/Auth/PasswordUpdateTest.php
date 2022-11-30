<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('password can be updated', function () {
    $user = modelBuilderHelper()->user->create();
    authHelper()->signIn($user);

    $response = $this
        ->from(routeBuilderHelper()->common->profile())
        ->put(routeBuilderHelper()->auth->password(), [
            'current_password'      => 'password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(routeBuilderHelper()->common->profile());

    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});

test('correct password must be provided to update password', function () {
    authHelper()->signIn();

    $response = $this
        ->from(routeBuilderHelper()->common->profile())
        ->put(routeBuilderHelper()->auth->password(), [
            'current_password'      => 'wrong-password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect(routeBuilderHelper()->common->profile());
});

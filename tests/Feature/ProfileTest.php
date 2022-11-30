<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile page is displayed', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->common->profile())->assertOk();
});

test('profile information can be updated', function () {
    $user = modelBuilderHelper()->user->create();
    authHelper()->signIn($user);

    $response = $this->patch(routeBuilderHelper()->common->profile(), [
        'name'  => 'Test User',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect(routeBuilderHelper()->common->profile());

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = modelBuilderHelper()->user->create();
    authHelper()->signIn($user);

    $response = $this
        ->patch(routeBuilderHelper()->common->profile(), [
            'name'  => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(routeBuilderHelper()->common->profile());

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = modelBuilderHelper()->user->create();
    authHelper()->signIn($user);

    $response = $this
        ->delete(routeBuilderHelper()->common->profile(), [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(routeBuilderHelper()->common->home());

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = modelBuilderHelper()->user->create();
    authHelper()->signIn($user);

    $response = $this
        ->from(routeBuilderHelper()->common->profile())
        ->delete(routeBuilderHelper()->common->profile(), [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect(routeBuilderHelper()->common->profile());

    $this->assertNotNull($user->fresh());
});

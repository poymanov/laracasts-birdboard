<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = modelBuilderHelper()->user->create([
        'email_verified_at' => null,
    ]);

    authHelper()->signIn($user);

    $this->get(routeBuilderHelper()->auth->verifyEmail())->assertOk();
});

test('email can be verified', function () {
    $user = modelBuilderHelper()->user->create([
        'email_verified_at' => null,
    ]);

    authHelper()->signIn($user);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    $this->assertTrue($user->fresh()->hasVerifiedEmail());
    $response->assertRedirect(routeBuilderHelper()->common->dashboard() . '?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = modelBuilderHelper()->user->create([
        'email_verified_at' => null,
    ]);

    authHelper()->signIn($user);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->get($verificationUrl);

    $this->assertFalse($user->fresh()->hasVerifiedEmail());
});

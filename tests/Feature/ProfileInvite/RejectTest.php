<?php

use App\Enums\ProjectInviteStatusEnum;
use App\Services\ProjectInvite\Notifications\RejectInvite;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Отклонение для гостя запрещено */
test('guest', function () {
    $invite = modelBuilderHelper()->projectInvite->create(['status' => ProjectInviteStatusEnum::SENT]);

    $this
        ->delete(routeBuilderHelper()->profileInvite->reject($invite->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка отклонения несуществующего приглашения */
test('not existed', function () {
    authHelper()->signIn();
    $this
        ->delete(routeBuilderHelper()->profileInvite->reject(faker()->uuid))
        ->assertForbidden();
});

/** Попытка отклонения приглашения другого пользователя */
test('another user', function () {
    authHelper()->signIn();

    $invite = modelBuilderHelper()->projectInvite->create(['status' => ProjectInviteStatusEnum::SENT]);

    $this
        ->delete(routeBuilderHelper()->profileInvite->reject($invite->id))
        ->assertForbidden();
});

/** Попытка отклонения приглашения в статусе "Отклонено" */
test('rejected status', function () {
    $user   = modelBuilderHelper()->user->create();
    $invite = modelBuilderHelper()->projectInvite->create(['user_id' => $user->id, 'status' => ProjectInviteStatusEnum::REJECTED]);

    authHelper()->signIn($user);

    $this
        ->delete(routeBuilderHelper()->profileInvite->reject($invite->id))
        ->assertForbidden();
});

/** Попытка отклонения приглашения в статусе "Подтверждено" */
test('accepted status', function () {
    $user   = modelBuilderHelper()->user->create();
    $invite = modelBuilderHelper()->projectInvite->create(['user_id' => $user->id, 'status' => ProjectInviteStatusEnum::ACCEPTED]);

    authHelper()->signIn($user);

    $this
        ->delete(routeBuilderHelper()->profileInvite->reject($invite->id))
        ->assertForbidden();
});

/** Приглашение отклонено */
test('success', function () {
    Notification::fake();

    $projectOwner = modelBuilderHelper()->user->create();
    $project      = modelBuilderHelper()->project->create(['owner_id' => $projectOwner->id]);
    $user         = modelBuilderHelper()->user->create();
    $invite       = modelBuilderHelper()->projectInvite->create([
        'project_id' => $project->id,
        'user_id'    => $user->id,
        'status'     => ProjectInviteStatusEnum::SENT,
    ]);

    authHelper()->signIn($user);

    $this
        ->delete(routeBuilderHelper()->profileInvite->reject($invite->id))
        ->assertRedirect(routeBuilderHelper()->profileInvite->index());

    $this->assertDatabaseHas('project_invites', [
        'id'     => $invite->id,
        'status' => ProjectInviteStatusEnum::REJECTED->value,
    ]);

    Notification::assertSentTo($projectOwner, RejectInvite::class);
});

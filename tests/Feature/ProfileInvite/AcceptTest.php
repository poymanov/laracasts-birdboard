<?php

use App\Enums\ProjectInviteStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Подтверждение для гостя запрещено */
test('guest', function () {
    $invite = modelBuilderHelper()->projectInvite->create(['status' => ProjectInviteStatusEnum::SENT]);

    $this
        ->patch(routeBuilderHelper()->profileInvite->accept($invite->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка подтверждения несуществующего приглашения */
test('not existed', function () {
    authHelper()->signIn();
    $this
        ->patch(routeBuilderHelper()->profileInvite->accept(faker()->uuid))
        ->assertForbidden();
});

/** Попытка подтверждения приглашения другого пользователя */
test('another user', function () {
    authHelper()->signIn();

    $invite = modelBuilderHelper()->projectInvite->create(['status' => ProjectInviteStatusEnum::SENT]);

    $this
        ->patch(routeBuilderHelper()->profileInvite->accept($invite->id))
        ->assertForbidden();
});

/** Попытка отклонения приглашения в статусе "Подтверждено" */
test('accepted status', function () {
    $user   = modelBuilderHelper()->user->create();
    $invite = modelBuilderHelper()->projectInvite->create(['user_id' => $user->id, 'status' => ProjectInviteStatusEnum::ACCEPTED]);

    authHelper()->signIn($user);

    $this
        ->patch(routeBuilderHelper()->profileInvite->accept($invite->id))
        ->assertForbidden();
});

/** Попытка отклонения приглашения в статусе "Отклонено" */
test('rejected status', function () {
    $user   = modelBuilderHelper()->user->create();
    $invite = modelBuilderHelper()->projectInvite->create(['user_id' => $user->id, 'status' => ProjectInviteStatusEnum::REJECTED]);

    authHelper()->signIn($user);

    $this
        ->patch(routeBuilderHelper()->profileInvite->accept($invite->id))
        ->assertForbidden();
});

/** Приглашение принято */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create();
    $invite  = modelBuilderHelper()->projectInvite->create([
        'project_id' => $project->id,
        'user_id'    => $user->id,
        'status'     => ProjectInviteStatusEnum::SENT,
    ]);

    authHelper()->signIn($user);

    $this
        ->patch(routeBuilderHelper()->profileInvite->accept($invite->id))
        ->assertRedirect(routeBuilderHelper()->profileInvite->index());

    $this->assertDatabaseHas('project_invites', [
        'id'     => $invite->id,
        'status' => ProjectInviteStatusEnum::ACCEPTED->value,
    ]);

    $this->assertDatabaseHas('project_members', [
        'project_id' => $project->id,
        'user_id'    => $user->id,
        'invite_id'  => $invite->id,
    ]);
});

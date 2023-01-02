<?php

use App\Enums\ProjectInviteStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Приглашение для гостя запрещено */
test('guest', function () {
    $project = modelBuilderHelper()->project->create();

    $this
        ->post(routeBuilderHelper()->invite->store($project->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Приглашение для чужого проекта */
test('not project owner', function () {
    $project      = modelBuilderHelper()->project->create();
    $userToInvite = modelBuilderHelper()->user->create();

    authHelper()->signIn();

    $this
        ->post(routeBuilderHelper()->invite->store($project->id), ['email' => $userToInvite->email])
        ->assertForbidden();
});

/** Несуществующий проект */
test('not exists', function () {
    $userToInvite = modelBuilderHelper()->user->create();

    authHelper()->signIn();

    $this
        ->post(routeBuilderHelper()->invite->store(faker()->uuid), ['email' => $userToInvite->email])
        ->assertForbidden();
});

/** Приглашение без данных */
test('empty', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->invite->store($project->id));
    $response->assertSessionHasErrors('email');
});

/** Приглашение с указанием некорректного email */
test('wrong email', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->invite->store($project->id), ['email' => 'test']);
    $response->assertSessionHasErrors('email');
});

/** Приглашение несуществующего пользователя */
test('not existed user', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->invite->store($project->id), ['email' => 'test@test.ru']);
    $response->assertSessionHasErrors('email');
});

/** Попытка приглашения самого себя */
test('self', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->post(routeBuilderHelper()->invite->store($project->id), ['email' => $user->email]);
    $response->assertRedirect(routeBuilderHelper()->member->index($project->id));

    $this->assertDatabaseMissing('project_invites', [
        'project_id' => $project->id,
        'user_id'    => $user->id,
    ]);
});

/** Пользователь уже приглашен */
test('already', function () {
    $user        = modelBuilderHelper()->user->create();
    $invitedUser = modelBuilderHelper()->user->create();
    $project     = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    $inviteStatus = ProjectInviteStatusEnum::SENT->value;
    modelBuilderHelper()->projectInvite->create(['project_id' => $project->id, 'user_id' => $invitedUser->id, 'status' => $inviteStatus]);

    authHelper()->signIn($user);

    $response = $this->post(routeBuilderHelper()->invite->store($project->id), ['email' => $invitedUser->email]);
    $response->assertRedirect(routeBuilderHelper()->member->index($project->id));

    $this->assertDatabaseMissing('project_invites', [
        'project_id' => $project->id,
        'user_id'    => $user->id,
        'status'     => $inviteStatus,
    ]);
});

/** Успешное создание приглашения */
test('success', function () {
    $user         = modelBuilderHelper()->user->create();
    $userToInvite = modelBuilderHelper()->user->create();
    $project      = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->post(routeBuilderHelper()->invite->store($project->id), ['email' => $userToInvite->email]);
    $response->assertRedirect(routeBuilderHelper()->member->index($project->id));

    $this->assertDatabaseHas('project_invites', [
        'project_id' => $project->id,
        'user_id'    => $userToInvite->id,
        'status'     => ProjectInviteStatusEnum::SENT->value,
    ]);
});

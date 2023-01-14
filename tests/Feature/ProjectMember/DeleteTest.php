<?php

use App\Services\ProjectInvite\Notifications\DeleteMember;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Удаление участника для гостя запрещено */
test('guest', function () {
    $project       = modelBuilderHelper()->project->create();
    $projectMember = modelBuilderHelper()->projectMember->create(['project_id' => $project->id]);

    $this
        ->delete(routeBuilderHelper()->member->delete($project->id, $projectMember->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления участника для чужого проекта */
test('another project', function () {
    $project       = modelBuilderHelper()->project->create();
    $projectMember = modelBuilderHelper()->projectMember->create(['project_id' => $project->id]);

    authHelper()->signIn();

    $this
        ->delete(routeBuilderHelper()->member->delete($project->id, $projectMember->id))
        ->assertForbidden();
});

/** Попытка удаления участника для несуществующего проекта */
test('not existed project', function () {
    $projectMember = modelBuilderHelper()->projectMember->create();

    authHelper()->signIn();

    $this
        ->delete(routeBuilderHelper()->member->delete(faker()->uuid, $projectMember->id))
        ->assertForbidden();
});

/** Попытка удаления несуществующего участника проекта */
test('not existed member', function () {
    $project = modelBuilderHelper()->project->create();

    authHelper()->signIn();

    $this
        ->delete(routeBuilderHelper()->member->delete($project->id, faker()->uuid))
        ->assertForbidden();
});

/** Попытка удаления участника проекта, не относящегося к проекту */
test('another project member', function () {
    $user          = modelBuilderHelper()->user->create();
    $project       = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $projectMember = modelBuilderHelper()->projectMember->create();

    authHelper()->signIn($user);

    $this
        ->delete(routeBuilderHelper()->member->delete($project->id, $projectMember->id))
        ->assertForbidden();
});

/** Успешное удаление участника */
test('success', function () {
    Notification::fake();

    $user          = modelBuilderHelper()->user->create();
    $project       = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $userMember    = modelBuilderHelper()->user->create();
    $projectMember = modelBuilderHelper()->projectMember->create(['project_id' => $project->id, 'user_id' => $userMember->id]);

    authHelper()->signIn($user);

    $response = $this->delete(routeBuilderHelper()->member->delete($project->id, $projectMember->id));
    $response->assertRedirect(routeBuilderHelper()->member->index($project->id));

    $this->assertDatabaseMissing('project_members', [
        'id'         => $projectMember->id,
        'deleted_at' => null,
    ]);

    $this->assertDatabaseMissing('project_invites', [
        'id'         => $projectMember->invite_id,
        'deleted_at' => null,
    ]);

    $this->assertDatabaseCount('project_activities', 1);

    $this->assertDatabaseHas('project_activities', [
        'user_id'    => $projectMember->user->id,
        'project_id' => $project->id,
        'type'       => 'delete_member',
    ]);

    Notification::assertSentTo($userMember, DeleteMember::class);
});

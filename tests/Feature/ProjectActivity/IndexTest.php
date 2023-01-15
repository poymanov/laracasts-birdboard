<?php

use App\Enums\ProjectActivityTypeEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

/** Просмотр без активностей */
test('empty', function () {
    $user    = modelBuilderHelper()->user->create();
    $project = modelBuilderHelper()->project->create(['owner_id' => $user->id]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(fn (Assert $page) => $page->has('activities', 0));
});

/** Активность - создание проекта */
test('create project', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::CREATE_PROJECT->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
        );
});

/** Активность - обновление заголовка проекта */
test('update project title', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_PROJECT_TITLE->value,
        'old_value'  => 'test',
        'new_value'  => 'test2',
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
                ->where('activities.0.oldValue', $activity->old_value)
                ->where('activities.0.newValue', $activity->new_value)
        );
});

/** Активность - обновление описания проекта */
test('update project description', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_PROJECT_DESCRIPTION->value,
        'old_value'  => 'test',
        'new_value'  => 'test2',
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
                ->where('activities.0.oldValue', $activity->old_value)
                ->where('activities.0.newValue', $activity->new_value)
        );
});

/** Активность - обновление заметок проекта */
test('update project notes', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_PROJECT_NOTES->value,
        'old_value'  => 'test',
        'new_value'  => 'test2',
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
                ->where('activities.0.oldValue', $activity->old_value)
                ->where('activities.0.newValue', $activity->new_value)
        );
});

/** Активность - создание задачи */
test('create task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::CREATE_TASK->value,
        'new_value'  => 'test',
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
                ->where('activities.0.newValue', $activity->new_value)
        );
});

/** Активность - обновление задачи */
test('update task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_TASK->value,
        'old_value'  => 'test',
        'new_value'  => 'test2',
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
                ->where('activities.0.oldValue', $activity->old_value)
                ->where('activities.0.newValue', $activity->new_value)
        );
});

/** Активность - завершение задачи */
test('complete task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::COMPLETE_TASK->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
        );
});

/** Активность - отмена завершения задачи */
test('incomplete task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::INCOMPLETE_TASK->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
        );
});

/** Активность - новый участник */
test('new task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::NEW_MEMBER->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
        );
});

/** Активность - удаление участника */
test('delete task', function () {
    $user     = modelBuilderHelper()->user->create();
    $project  = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activity = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::DELETE_MEMBER->value,
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 1)
                ->where('activities.0.id', $activity->id)
                ->where('activities.0.type', $activity->type)
        );
});

/** Просмотр ограниченного количества последних активностей */
test('last', function () {
    $user           = modelBuilderHelper()->user->create();
    $project        = modelBuilderHelper()->project->create(['owner_id' => $user->id]);
    $activityFirst  = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::CREATE_PROJECT->value,
        'created_at' => Carbon::now()->addMinutes(5),
    ]);
    $activitySecond = modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_PROJECT_NOTES->value,
        'created_at' => Carbon::now()->addMinutes(4),
    ]);
    modelBuilderHelper()->projectActivity->create([
        'project_id' => $project->id,
        'type'       => ProjectActivityTypeEnum::UPDATE_PROJECT_TITLE->value,
        'created_at' => Carbon::now()->addMinutes(3),
    ]);

    authHelper()->signIn($user);

    $this
        ->get(routeBuilderHelper()->project->show($project->id))->assertInertia(
            fn (Assert $page) => $page->has('activities', 2)
                ->where('activities.0.id', $activityFirst->id)
                ->where('activities.1.id', $activitySecond->id)
        );
});

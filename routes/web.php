<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileInviteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInviteController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'prefix'     => 'profile',
        'as'         => 'profile.',
        'controller' => ProfileController::class,
    ], function () {
        Route::get('', 'edit')->name('edit');
        Route::patch('', 'update')->name('update');
        Route::delete('', 'destroy')->name('destroy');

        Route::group([
            'prefix'     => 'invitations',
            'as'         => 'invitations.',
            'controller' => ProfileInviteController::class,
        ], function () {
            Route::get('', 'index')->name('index');
            Route::patch('{id}/accept', 'accept')->name('accept');
            Route::delete('{id}/reject', 'reject')->name('reject');
        });
    });

    Route::group([
        'prefix'     => 'projects',
        'as'         => 'projects.',
        'controller' => ProjectController::class,
    ], function () {
        Route::get('create', 'create')->name('create');
        Route::get('{id}', 'show')->name('show');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::post('', 'store')->name('store');
        Route::patch('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');
        Route::patch('{id}/update-notes', 'updateNotes')->name('update-notes');

        Route::group([
            'prefix'     => '{id}/invitations',
            'as'         => 'invitations.',
            'controller' => ProjectInviteController::class,
        ], function () {
            Route::post('', 'store')->name('store');
        });

        Route::group([
            'prefix'     => '{projectId}/members',
            'as'         => 'members.',
            'controller' => ProjectMemberController::class,
        ], function () {
            Route::get('', 'index')->name('index');
            Route::delete('/{projectMemberId}', 'destroy')->name('destroy');
        });
    });

    Route::group([
        'prefix'     => 'tasks',
        'as'         => 'tasks.',
        'controller' => TaskController::class,
    ], function () {
        Route::post('', 'store')->name('store');
        Route::patch('{id}', 'update')->name('update');
    });
});

require __DIR__ . '/auth.php';

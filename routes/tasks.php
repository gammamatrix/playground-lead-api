<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead API Routes: Task
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/lead/task',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{task:slug}', [
        'as' => 'playground.lead.api.tasks.slug',
        'uses' => 'TaskController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/tasks',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.tasks',
        'uses' => 'TaskController@index',
    ])->can('index', Playground\Lead\Models\Task::class);

    Route::post('/index', [
        'as' => 'playground.lead.api.tasks.index',
        'uses' => 'TaskController@index',
    ])->can('index', Playground\Lead\Models\Task::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.tasks.create',
        'uses' => 'TaskController@create',
    ])->can('create', Playground\Lead\Models\Task::class);

    Route::get('/edit/{task}', [
        'as' => 'playground.lead.api.tasks.edit',
        'uses' => 'TaskController@edit',
    ])->whereUuid('task')->can('edit', 'task');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.lead.api.tasks.go',
    //     'uses' => 'TaskController@go',
    // ]);

    Route::get('/{task}', [
        'as' => 'playground.lead.api.tasks.show',
        'uses' => 'TaskController@show',
    ])->whereUuid('task')->can('detail', 'task');

    // API

    Route::put('/lock/{task}', [
        'as' => 'playground.lead.api.tasks.lock',
        'uses' => 'TaskController@lock',
    ])->whereUuid('task')->can('lock', 'task');

    Route::delete('/lock/{task}', [
        'as' => 'playground.lead.api.tasks.unlock',
        'uses' => 'TaskController@unlock',
    ])->whereUuid('task')->can('unlock', 'task');

    Route::delete('/{task}', [
        'as' => 'playground.lead.api.tasks.destroy',
        'uses' => 'TaskController@destroy',
    ])->whereUuid('task')->can('delete', 'task')->withTrashed();

    Route::put('/restore/{task}', [
        'as' => 'playground.lead.api.tasks.restore',
        'uses' => 'TaskController@restore',
    ])->whereUuid('task')->can('restore', 'task')->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.tasks.post',
        'uses' => 'TaskController@store',
    ])->can('store', Playground\Lead\Models\Task::class);

    // Route::put('/', [
    //     'as' => 'playground.lead.api.tasks.put',
    //     'uses' => 'TaskController@store',
    // ])->can('store', Playground\Lead\Models\Task::class);
    //
    // Route::put('/{task}', [
    //     'as' => 'playground.lead.api.tasks.put.id',
    //     'uses' => 'TaskController@store',
    // ])->whereUuid('task')->can('update', 'task');

    Route::patch('/{task}', [
        'as' => 'playground.lead.api.tasks.patch',
        'uses' => 'TaskController@update',
    ])->whereUuid('task')->can('update', 'task');
});

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead Routes: Goal
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/lead/goal',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{goal:slug}', [
        'as' => 'playground.lead.api.goals.slug',
        'uses' => 'GoalController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/goals',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.goals',
        'uses' => 'GoalController@index',
    ])->can('index', Playground\Lead\Models\Goal::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.goals.create',
        'uses' => 'GoalController@create',
    ])->can('create', Playground\Lead\Models\Goal::class);

    Route::get('/edit/{goal}', [
        'as' => 'playground.lead.api.goals.edit',
        'uses' => 'GoalController@edit',
    ])->whereUuid('goal')
        ->can('edit', 'goal');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.lead.api.goals.go',
    //     'uses' => 'GoalController@go',
    // ]);

    Route::get('/{goal}', [
        'as' => 'playground.lead.api.goals.show',
        'uses' => 'GoalController@show',
    ])->whereUuid('goal')
        ->can('detail', 'goal');

    // API

    Route::put('/lock/{goal}', [
        'as' => 'playground.lead.api.goals.lock',
        'uses' => 'GoalController@lock',
    ])->whereUuid('goal')
        ->can('lock', 'goal');

    Route::delete('/lock/{goal}', [
        'as' => 'playground.lead.api.goals.unlock',
        'uses' => 'GoalController@unlock',
    ])->whereUuid('goal')
        ->can('unlock', 'goal');

    Route::delete('/{goal}', [
        'as' => 'playground.lead.api.goals.destroy',
        'uses' => 'GoalController@destroy',
    ])->whereUuid('goal')
        ->can('delete', 'goal')
        ->withTrashed();

    Route::put('/restore/{goal}', [
        'as' => 'playground.lead.api.goals.restore',
        'uses' => 'GoalController@restore',
    ])->whereUuid('goal')
        ->can('restore', 'goal')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.goals.post',
        'uses' => 'GoalController@store',
    ])->can('store', Playground\Lead\Models\Goal::class);

    // Route::put('/', [
    //     'as'   => 'playground.lead.api.goals.put',
    //     'uses' => 'GoalController@store',
    // ])->can('store', \Playground\Lead\Models\Goal::class);
    //
    // Route::put('/{goal}', [
    //     'as'   => 'playground.lead.api.goals.put.id',
    //     'uses' => 'GoalController@store',
    // ])->whereUuid('goal')->can('update', 'goal');

    Route::patch('/{goal}', [
        'as' => 'playground.lead.api.goals.patch',
        'uses' => 'GoalController@update',
    ])->whereUuid('goal')->can('update', 'goal');
});

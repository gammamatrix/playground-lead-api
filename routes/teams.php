<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead Routes: Team
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/lead/team',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{team:slug}', [
        'as' => 'playground.lead.api.teams.slug',
        'uses' => 'TeamController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/teams',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.teams',
        'uses' => 'TeamController@index',
    ])->can('index', Playground\Lead\Models\Team::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.teams.create',
        'uses' => 'TeamController@create',
    ])->can('create', Playground\Lead\Models\Team::class);

    Route::get('/edit/{team}', [
        'as' => 'playground.lead.api.teams.edit',
        'uses' => 'TeamController@edit',
    ])->whereUuid('team')
        ->can('edit', 'team');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.lead.api.teams.go',
    //     'uses' => 'TeamController@go',
    // ]);

    Route::get('/{team}', [
        'as' => 'playground.lead.api.teams.show',
        'uses' => 'TeamController@show',
    ])->whereUuid('team')
        ->can('detail', 'team');

    // API

    Route::put('/lock/{team}', [
        'as' => 'playground.lead.api.teams.lock',
        'uses' => 'TeamController@lock',
    ])->whereUuid('team')
        ->can('lock', 'team');

    Route::delete('/lock/{team}', [
        'as' => 'playground.lead.api.teams.unlock',
        'uses' => 'TeamController@unlock',
    ])->whereUuid('team')
        ->can('unlock', 'team');

    Route::delete('/{team}', [
        'as' => 'playground.lead.api.teams.destroy',
        'uses' => 'TeamController@destroy',
    ])->whereUuid('team')
        ->can('delete', 'team')
        ->withTrashed();

    Route::put('/restore/{team}', [
        'as' => 'playground.lead.api.teams.restore',
        'uses' => 'TeamController@restore',
    ])->whereUuid('team')
        ->can('restore', 'team')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.teams.post',
        'uses' => 'TeamController@store',
    ])->can('store', Playground\Lead\Models\Team::class);

    // Route::put('/', [
    //     'as'   => 'playground.lead.api.teams.put',
    //     'uses' => 'TeamController@store',
    // ])->can('store', \Playground\Lead\Models\Team::class);
    //
    // Route::put('/{team}', [
    //     'as'   => 'playground.lead.api.teams.put.id',
    //     'uses' => 'TeamController@store',
    // ])->whereUuid('team')->can('update', 'team');

    Route::patch('/{team}', [
        'as' => 'playground.lead.api.teams.patch',
        'uses' => 'TeamController@update',
    ])->whereUuid('team')->can('update', 'team');
});

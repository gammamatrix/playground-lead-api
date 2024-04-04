<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead Routes: Teammate
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/lead/teammate',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{teammate:slug}', [
        'as' => 'playground.lead.api.teammates.slug',
        'uses' => 'TeammateController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/teammates',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.teammates',
        'uses' => 'TeammateController@index',
    ])->can('index', Playground\Lead\Models\Teammate::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.teammates.create',
        'uses' => 'TeammateController@create',
    ])->can('create', Playground\Lead\Models\Teammate::class);

    Route::get('/edit/{teammate}', [
        'as' => 'playground.lead.api.teammates.edit',
        'uses' => 'TeammateController@edit',
    ])->whereUuid('teammate')
        ->can('edit', 'teammate');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.lead.api.teammates.go',
    //     'uses' => 'TeammateController@go',
    // ]);

    Route::get('/{teammate}', [
        'as' => 'playground.lead.api.teammates.show',
        'uses' => 'TeammateController@show',
    ])->whereUuid('teammate')
        ->can('detail', 'teammate');

    // API

    Route::put('/lock/{teammate}', [
        'as' => 'playground.lead.api.teammates.lock',
        'uses' => 'TeammateController@lock',
    ])->whereUuid('teammate')
        ->can('lock', 'teammate');

    Route::delete('/lock/{teammate}', [
        'as' => 'playground.lead.api.teammates.unlock',
        'uses' => 'TeammateController@unlock',
    ])->whereUuid('teammate')
        ->can('unlock', 'teammate');

    Route::delete('/{teammate}', [
        'as' => 'playground.lead.api.teammates.destroy',
        'uses' => 'TeammateController@destroy',
    ])->whereUuid('teammate')
        ->can('delete', 'teammate')
        ->withTrashed();

    Route::put('/restore/{teammate}', [
        'as' => 'playground.lead.api.teammates.restore',
        'uses' => 'TeammateController@restore',
    ])->whereUuid('teammate')
        ->can('restore', 'teammate')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.teammates.post',
        'uses' => 'TeammateController@store',
    ])->can('store', Playground\Lead\Models\Teammate::class);

    // Route::put('/', [
    //     'as'   => 'playground.lead.api.teammates.put',
    //     'uses' => 'TeammateController@store',
    // ])->can('store', \Playground\Lead\Models\Teammate::class);
    //
    // Route::put('/{teammate}', [
    //     'as'   => 'playground.lead.api.teammates.put.id',
    //     'uses' => 'TeammateController@store',
    // ])->whereUuid('teammate')->can('update', 'teammate');

    Route::patch('/{teammate}', [
        'as' => 'playground.lead.api.teammates.patch',
        'uses' => 'TeammateController@update',
    ])->whereUuid('teammate')->can('update', 'teammate');
});

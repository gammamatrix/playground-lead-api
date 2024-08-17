<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead API Routes: Region
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/lead/region',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{region:slug}', [
        'as' => 'playground.lead.api.regions.slug',
        'uses' => 'RegionController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/regions',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.regions',
        'uses' => 'RegionController@index',
    ])->can('index', Playground\Lead\Models\Region::class);

    Route::post('/index', [
        'as' => 'playground.lead.api.regions.index',
        'uses' => 'RegionController@index',
    ])->can('index', Playground\Lead\Models\Region::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.regions.create',
        'uses' => 'RegionController@create',
    ])->can('create', Playground\Lead\Models\Region::class);

    Route::get('/edit/{region}', [
        'as' => 'playground.lead.api.regions.edit',
        'uses' => 'RegionController@edit',
    ])->whereUuid('region')->can('edit', 'region');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.lead.api.regions.go',
    //     'uses' => 'RegionController@go',
    // ]);

    Route::get('/{region}', [
        'as' => 'playground.lead.api.regions.show',
        'uses' => 'RegionController@show',
    ])->whereUuid('region')->can('detail', 'region');

    // API

    Route::put('/lock/{region}', [
        'as' => 'playground.lead.api.regions.lock',
        'uses' => 'RegionController@lock',
    ])->whereUuid('region')->can('lock', 'region');

    Route::delete('/lock/{region}', [
        'as' => 'playground.lead.api.regions.unlock',
        'uses' => 'RegionController@unlock',
    ])->whereUuid('region')->can('unlock', 'region');

    Route::delete('/{region}', [
        'as' => 'playground.lead.api.regions.destroy',
        'uses' => 'RegionController@destroy',
    ])->whereUuid('region')->can('delete', 'region')->withTrashed();

    Route::put('/restore/{region}', [
        'as' => 'playground.lead.api.regions.restore',
        'uses' => 'RegionController@restore',
    ])->whereUuid('region')->can('restore', 'region')->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.regions.post',
        'uses' => 'RegionController@store',
    ])->can('store', Playground\Lead\Models\Region::class);

    // Route::put('/', [
    //     'as' => 'playground.lead.api.regions.put',
    //     'uses' => 'RegionController@store',
    // ])->can('store', Playground\Lead\Models\Region::class);
    //
    // Route::put('/{region}', [
    //     'as' => 'playground.lead.api.regions.put.id',
    //     'uses' => 'RegionController@store',
    // ])->whereUuid('region')->can('update', 'region');

    Route::patch('/{region}', [
        'as' => 'playground.lead.api.regions.patch',
        'uses' => 'RegionController@update',
    ])->whereUuid('region')->can('update', 'region');
});

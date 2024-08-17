<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead API Routes: Source
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/lead/source',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{source:slug}', [
        'as' => 'playground.lead.api.sources.slug',
        'uses' => 'SourceController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/sources',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.sources',
        'uses' => 'SourceController@index',
    ])->can('index', Playground\Lead\Models\Source::class);

    Route::post('/index', [
        'as' => 'playground.lead.api.sources.index',
        'uses' => 'SourceController@index',
    ])->can('index', Playground\Lead\Models\Source::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.sources.create',
        'uses' => 'SourceController@create',
    ])->can('create', Playground\Lead\Models\Source::class);

    Route::get('/edit/{source}', [
        'as' => 'playground.lead.api.sources.edit',
        'uses' => 'SourceController@edit',
    ])->whereUuid('source')->can('edit', 'source');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.lead.api.sources.go',
    //     'uses' => 'SourceController@go',
    // ]);

    Route::get('/{source}', [
        'as' => 'playground.lead.api.sources.show',
        'uses' => 'SourceController@show',
    ])->whereUuid('source')->can('detail', 'source');

    // API

    Route::put('/lock/{source}', [
        'as' => 'playground.lead.api.sources.lock',
        'uses' => 'SourceController@lock',
    ])->whereUuid('source')->can('lock', 'source');

    Route::delete('/lock/{source}', [
        'as' => 'playground.lead.api.sources.unlock',
        'uses' => 'SourceController@unlock',
    ])->whereUuid('source')->can('unlock', 'source');

    Route::delete('/{source}', [
        'as' => 'playground.lead.api.sources.destroy',
        'uses' => 'SourceController@destroy',
    ])->whereUuid('source')->can('delete', 'source')->withTrashed();

    Route::put('/restore/{source}', [
        'as' => 'playground.lead.api.sources.restore',
        'uses' => 'SourceController@restore',
    ])->whereUuid('source')->can('restore', 'source')->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.sources.post',
        'uses' => 'SourceController@store',
    ])->can('store', Playground\Lead\Models\Source::class);

    // Route::put('/', [
    //     'as' => 'playground.lead.api.sources.put',
    //     'uses' => 'SourceController@store',
    // ])->can('store', Playground\Lead\Models\Source::class);
    //
    // Route::put('/{source}', [
    //     'as' => 'playground.lead.api.sources.put.id',
    //     'uses' => 'SourceController@store',
    // ])->whereUuid('source')->can('update', 'source');

    Route::patch('/{source}', [
        'as' => 'playground.lead.api.sources.patch',
        'uses' => 'SourceController@update',
    ])->whereUuid('source')->can('update', 'source');
});

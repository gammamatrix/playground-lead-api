<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead API Routes: Opportunity
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/lead/opportunity',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{opportunity:slug}', [
        'as' => 'playground.lead.api.opportunities.slug',
        'uses' => 'OpportunityController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/opportunities',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.opportunities',
        'uses' => 'OpportunityController@index',
    ])->can('index', Playground\Lead\Models\Opportunity::class);

    Route::post('/index', [
        'as' => 'playground.lead.api.opportunities.index',
        'uses' => 'OpportunityController@index',
    ])->can('index', Playground\Lead\Models\Opportunity::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.opportunities.create',
        'uses' => 'OpportunityController@create',
    ])->can('create', Playground\Lead\Models\Opportunity::class);

    Route::get('/edit/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.edit',
        'uses' => 'OpportunityController@edit',
    ])->whereUuid('opportunity')->can('edit', 'opportunity');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.lead.api.opportunities.go',
    //     'uses' => 'OpportunityController@go',
    // ]);

    Route::get('/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.show',
        'uses' => 'OpportunityController@show',
    ])->whereUuid('opportunity')->can('detail', 'opportunity');

    // API

    Route::put('/lock/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.lock',
        'uses' => 'OpportunityController@lock',
    ])->whereUuid('opportunity')->can('lock', 'opportunity');

    Route::delete('/lock/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.unlock',
        'uses' => 'OpportunityController@unlock',
    ])->whereUuid('opportunity')->can('unlock', 'opportunity');

    Route::delete('/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.destroy',
        'uses' => 'OpportunityController@destroy',
    ])->whereUuid('opportunity')->can('delete', 'opportunity')->withTrashed();

    Route::put('/restore/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.restore',
        'uses' => 'OpportunityController@restore',
    ])->whereUuid('opportunity')->can('restore', 'opportunity')->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.opportunities.post',
        'uses' => 'OpportunityController@store',
    ])->can('store', Playground\Lead\Models\Opportunity::class);

    // Route::put('/', [
    //     'as' => 'playground.lead.api.opportunities.put',
    //     'uses' => 'OpportunityController@store',
    // ])->can('store', Playground\Lead\Models\Opportunity::class);
    //
    // Route::put('/{opportunity}', [
    //     'as' => 'playground.lead.api.opportunities.put.id',
    //     'uses' => 'OpportunityController@store',
    // ])->whereUuid('opportunity')->can('update', 'opportunity');

    Route::patch('/{opportunity}', [
        'as' => 'playground.lead.api.opportunities.patch',
        'uses' => 'OpportunityController@update',
    ])->whereUuid('opportunity')->can('update', 'opportunity');
});

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead Routes: Lead
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/lead/lead',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{lead:slug}', [
        'as' => 'playground.lead.api.leads.slug',
        'uses' => 'LeadController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/leads',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.leads',
        'uses' => 'LeadController@index',
    ])->can('index', Playground\Lead\Models\Lead::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.leads.create',
        'uses' => 'LeadController@create',
    ])->can('create', Playground\Lead\Models\Lead::class);

    Route::get('/edit/{lead}', [
        'as' => 'playground.lead.api.leads.edit',
        'uses' => 'LeadController@edit',
    ])->whereUuid('lead')
        ->can('edit', 'lead');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.lead.api.leads.go',
    //     'uses' => 'LeadController@go',
    // ]);

    Route::get('/{lead}', [
        'as' => 'playground.lead.api.leads.show',
        'uses' => 'LeadController@show',
    ])->whereUuid('lead')
        ->can('detail', 'lead');

    // API

    Route::put('/lock/{lead}', [
        'as' => 'playground.lead.api.leads.lock',
        'uses' => 'LeadController@lock',
    ])->whereUuid('lead')
        ->can('lock', 'lead');

    Route::delete('/lock/{lead}', [
        'as' => 'playground.lead.api.leads.unlock',
        'uses' => 'LeadController@unlock',
    ])->whereUuid('lead')
        ->can('unlock', 'lead');

    Route::delete('/{lead}', [
        'as' => 'playground.lead.api.leads.destroy',
        'uses' => 'LeadController@destroy',
    ])->whereUuid('lead')
        ->can('delete', 'lead')
        ->withTrashed();

    Route::put('/restore/{lead}', [
        'as' => 'playground.lead.api.leads.restore',
        'uses' => 'LeadController@restore',
    ])->whereUuid('lead')
        ->can('restore', 'lead')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.leads.post',
        'uses' => 'LeadController@store',
    ])->can('store', Playground\Lead\Models\Lead::class);

    // Route::put('/', [
    //     'as'   => 'playground.lead.api.leads.put',
    //     'uses' => 'LeadController@store',
    // ])->can('store', \Playground\Lead\Models\Lead::class);
    //
    // Route::put('/{lead}', [
    //     'as'   => 'playground.lead.api.leads.put.id',
    //     'uses' => 'LeadController@store',
    // ])->whereUuid('lead')->can('update', 'lead');

    Route::patch('/{lead}', [
        'as' => 'playground.lead.api.leads.patch',
        'uses' => 'LeadController@update',
    ])->whereUuid('lead')->can('update', 'lead');
});

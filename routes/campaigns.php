<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead Routes: Campaign
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/lead/campaign',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{campaign:slug}', [
        'as' => 'playground.lead.api.campaigns.slug',
        'uses' => 'CampaignController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/campaigns',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.campaigns',
        'uses' => 'CampaignController@index',
    ])->can('index', Playground\Lead\Models\Campaign::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.campaigns.create',
        'uses' => 'CampaignController@create',
    ])->can('create', Playground\Lead\Models\Campaign::class);

    Route::get('/edit/{campaign}', [
        'as' => 'playground.lead.api.campaigns.edit',
        'uses' => 'CampaignController@edit',
    ])->whereUuid('campaign')
        ->can('edit', 'campaign');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.lead.api.campaigns.go',
    //     'uses' => 'CampaignController@go',
    // ]);

    Route::get('/{campaign}', [
        'as' => 'playground.lead.api.campaigns.show',
        'uses' => 'CampaignController@show',
    ])->whereUuid('campaign')
        ->can('detail', 'campaign');

    // API

    Route::put('/lock/{campaign}', [
        'as' => 'playground.lead.api.campaigns.lock',
        'uses' => 'CampaignController@lock',
    ])->whereUuid('campaign')
        ->can('lock', 'campaign');

    Route::delete('/lock/{campaign}', [
        'as' => 'playground.lead.api.campaigns.unlock',
        'uses' => 'CampaignController@unlock',
    ])->whereUuid('campaign')
        ->can('unlock', 'campaign');

    Route::delete('/{campaign}', [
        'as' => 'playground.lead.api.campaigns.destroy',
        'uses' => 'CampaignController@destroy',
    ])->whereUuid('campaign')
        ->can('delete', 'campaign')
        ->withTrashed();

    Route::put('/restore/{campaign}', [
        'as' => 'playground.lead.api.campaigns.restore',
        'uses' => 'CampaignController@restore',
    ])->whereUuid('campaign')
        ->can('restore', 'campaign')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.campaigns.post',
        'uses' => 'CampaignController@store',
    ])->can('store', Playground\Lead\Models\Campaign::class);

    // Route::put('/', [
    //     'as'   => 'playground.lead.api.campaigns.put',
    //     'uses' => 'CampaignController@store',
    // ])->can('store', \Playground\Lead\Models\Campaign::class);
    //
    // Route::put('/{campaign}', [
    //     'as'   => 'playground.lead.api.campaigns.put.id',
    //     'uses' => 'CampaignController@store',
    // ])->whereUuid('campaign')->can('update', 'campaign');

    Route::patch('/{campaign}', [
        'as' => 'playground.lead.api.campaigns.patch',
        'uses' => 'CampaignController@update',
    ])->whereUuid('campaign')->can('update', 'campaign');
});

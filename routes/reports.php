<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lead API Routes: Report
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/lead/report',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {

    Route::get('/{report:slug}', [
        'as' => 'playground.lead.api.reports.slug',
        'uses' => 'ReportController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/lead/reports',
    'middleware' => config('playground-lead-api.middleware.default'),
    'namespace' => '\Playground\Lead\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.lead.api.reports',
        'uses' => 'ReportController@index',
    ])->can('index', Playground\Lead\Models\Report::class);

    Route::post('/index', [
        'as' => 'playground.lead.api.reports.index',
        'uses' => 'ReportController@index',
    ])->can('index', Playground\Lead\Models\Report::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.lead.api.reports.create',
        'uses' => 'ReportController@create',
    ])->can('create', Playground\Lead\Models\Report::class);

    Route::get('/edit/{report}', [
        'as' => 'playground.lead.api.reports.edit',
        'uses' => 'ReportController@edit',
    ])->whereUuid('report')->can('edit', 'report');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.lead.api.reports.go',
    //     'uses' => 'ReportController@go',
    // ]);

    Route::get('/{report}', [
        'as' => 'playground.lead.api.reports.show',
        'uses' => 'ReportController@show',
    ])->whereUuid('report')->can('detail', 'report');

    // API

    Route::put('/lock/{report}', [
        'as' => 'playground.lead.api.reports.lock',
        'uses' => 'ReportController@lock',
    ])->whereUuid('report')->can('lock', 'report');

    Route::delete('/lock/{report}', [
        'as' => 'playground.lead.api.reports.unlock',
        'uses' => 'ReportController@unlock',
    ])->whereUuid('report')->can('unlock', 'report');

    Route::delete('/{report}', [
        'as' => 'playground.lead.api.reports.destroy',
        'uses' => 'ReportController@destroy',
    ])->whereUuid('report')->can('delete', 'report')->withTrashed();

    Route::put('/restore/{report}', [
        'as' => 'playground.lead.api.reports.restore',
        'uses' => 'ReportController@restore',
    ])->whereUuid('report')->can('restore', 'report')->withTrashed();

    Route::post('/', [
        'as' => 'playground.lead.api.reports.post',
        'uses' => 'ReportController@store',
    ])->can('store', Playground\Lead\Models\Report::class);

    // Route::put('/', [
    //     'as' => 'playground.lead.api.reports.put',
    //     'uses' => 'ReportController@store',
    // ])->can('store', Playground\Lead\Models\Report::class);
    //
    // Route::put('/{report}', [
    //     'as' => 'playground.lead.api.reports.put.id',
    //     'uses' => 'ReportController@store',
    // ])->whereUuid('report')->can('update', 'report');

    Route::patch('/{report}', [
        'as' => 'playground.lead.api.reports.patch',
        'uses' => 'ReportController@update',
    ])->whereUuid('report')->can('update', 'report');
});

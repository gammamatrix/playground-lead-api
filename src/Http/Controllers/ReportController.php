<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Report\CreateRequest;
use Playground\Lead\Api\Http\Requests\Report\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Report\EditRequest;
use Playground\Lead\Api\Http\Requests\Report\IndexRequest;
use Playground\Lead\Api\Http\Requests\Report\LockRequest;
use Playground\Lead\Api\Http\Requests\Report\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Report\ShowRequest;
use Playground\Lead\Api\Http\Requests\Report\StoreRequest;
use Playground\Lead\Api\Http\Requests\Report\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Report\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Report as ReportResource;
use Playground\Lead\Api\Http\Resources\ReportCollection;
use Playground\Lead\Models\Report;

/**
 * \Playground\Lead\Api\Http\Controllers\ReportController
 */
class ReportController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Report',
        'model_label_plural' => 'Reports',
        'model_route' => 'playground.lead.api.reports',
        'model_slug' => 'report',
        'model_slug_plural' => 'reports',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:report',
        'table' => 'lead_reports',
    ];

    /**
     * Create information for the Report resource in storage.
     *
     * @route GET /api/lead/reports/create playground.lead.api.reports.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|ReportResource {

        $validated = $request->validated();

        $report = new Report($validated);

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Report resource in storage.
     *
     * @route GET /api/lead/reports/edit playground.lead.api.reports.edit
     */
    public function edit(
        Report $report,
        EditRequest $request
    ): JsonResponse|ReportResource {
        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Report resource from storage.
     *
     * @route DELETE /api/lead/reports/{report} playground.lead.api.reports.destroy
     */
    public function destroy(
        Report $report,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $report->delete();
        } else {
            $report->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Report resource in storage.
     *
     * @route PUT /api/lead/reports/{report} playground.lead.api.reports.lock
     */
    public function lock(
        Report $report,
        LockRequest $request
    ): JsonResponse|ReportResource {
        $validated = $request->validated();

        $report->setAttribute('locked', true);

        $report->save();

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Report resources.
     *
     * @route GET /api/lead/reports playground.lead.api.reports
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|ReportCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Report::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new ReportCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Report resource from the trash.
     *
     * @route PUT /api/lead/reports/restore/{report} playground.lead.api.reports.restore
     */
    public function restore(
        Report $report,
        RestoreRequest $request
    ): JsonResponse|ReportResource {
        $validated = $request->validated();

        $user = $request->user();

        $report->restore();

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Report resource.
     *
     * @route GET /api/lead/reports/{report} playground.lead.api.reports.show
     */
    public function show(
        Report $report,
        ShowRequest $request
    ): JsonResponse|ReportResource {
        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Report resource in storage.
     *
     * @route POST /api/lead/reports playground.lead.api.reports.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|ReportResource {
        $validated = $request->validated();

        $user = $request->user();

        $report = new Report($validated);

        $report->created_by_id = $user?->id;

        $report->save();

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Report resource in storage.
     *
     * @route DELETE /api/lead/reports/lock/{report} playground.lead.api.reports.unlock
     */
    public function unlock(
        Report $report,
        UnlockRequest $request
    ): JsonResponse|ReportResource {
        $validated = $request->validated();

        $report->setAttribute('locked', false);

        $report->save();

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Report resource in storage.
     *
     * @route PATCH /api/lead/reports/{report} playground.lead.api.reports.patch
     */
    public function update(
        Report $report,
        UpdateRequest $request
    ): JsonResponse|ReportResource {
        $validated = $request->validated();

        $user = $request->user();

        $report->modified_by_id = $user?->id;

        $report->update($validated);

        return (new ReportResource($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

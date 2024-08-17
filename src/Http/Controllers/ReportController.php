<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Lead\Api\Http\Requests;
use Playground\Lead\Api\Http\Resources;
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
        'model_attribute' => 'title',
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
     * Create the Report resource in storage.
     *
     * @route GET /api/lead/reports/create playground.lead.api.reports.create
     */
    public function create(
        Requests\Report\CreateRequest $request
    ): JsonResponse|Resources\Report {

        $validated = $request->validated();

        $user = $request->user();

        $report = new Report($validated);

        return (new Resources\Report($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Report resource in storage.
     *
     * @route GET /api/lead/reports/edit playground.lead.api.reports.edit
     */
    public function edit(
        Report $report,
        Requests\Report\EditRequest $request
    ): JsonResponse|Resources\Report {
        return (new Resources\Report($report))->additional(['meta' => [
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
        Requests\Report\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $report->modified_by_id = $user->id;
        }

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
        Requests\Report\LockRequest $request
    ): JsonResponse|Resources\Report {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $report->modified_by_id = $user->id;
        }

        $report->locked = true;

        $report->save();

        return (new Resources\Report($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Report resources.
     *
     * @route GET /api/lead/reports playground.lead.api.reports
     */
    public function index(
        Requests\Report\IndexRequest $request
    ): JsonResponse|Resources\ReportCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\ReportCollection($paginator))->response($request);
    }

    /**
     * Restore the Report resource from the trash.
     *
     * @route PUT /api/lead/reports/restore/{report} playground.lead.api.reports.restore
     */
    public function restore(
        Report $report,
        Requests\Report\RestoreRequest $request
    ): JsonResponse|Resources\Report {

        $user = $request->user();

        if ($user?->id) {
            $report->modified_by_id = $user->id;
        }

        $report->restore();

        return (new Resources\Report($report))->additional(['meta' => [
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
        Requests\Report\ShowRequest $request
    ): JsonResponse|Resources\Report {
        return (new Resources\Report($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Report resource in storage.
     *
     * @route POST /api/lead/reports playground.lead.api.reports.post
     */
    public function store(
        Requests\Report\StoreRequest $request
    ): Response|JsonResponse|Resources\Report {
        $validated = $request->validated();

        $user = $request->user();

        $report = new Report($validated);

        $report->created_by_id = $user?->id;

        $report->save();

        return (new Resources\Report($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Report resource in storage.
     *
     * @route DELETE /api/lead/reports/lock/{report} playground.lead.api.reports.unlock
     */
    public function unlock(
        Report $report,
        Requests\Report\UnlockRequest $request
    ): JsonResponse|Resources\Report {

        $validated = $request->validated();

        $user = $request->user();

        $report->locked = false;

        if ($user?->id) {
            $report->modified_by_id = $user->id;
        }

        $report->save();

        return (new Resources\Report($report))->additional(['meta' => [
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
        Requests\Report\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $report->modified_by_id = $user->id;
        }

        $report->update($validated);

        return (new Resources\Report($report))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

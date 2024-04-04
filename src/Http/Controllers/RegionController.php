<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Region\CreateRequest;
use Playground\Lead\Api\Http\Requests\Region\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Region\EditRequest;
use Playground\Lead\Api\Http\Requests\Region\IndexRequest;
use Playground\Lead\Api\Http\Requests\Region\LockRequest;
use Playground\Lead\Api\Http\Requests\Region\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Region\ShowRequest;
use Playground\Lead\Api\Http\Requests\Region\StoreRequest;
use Playground\Lead\Api\Http\Requests\Region\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Region\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Region as RegionResource;
use Playground\Lead\Api\Http\Resources\RegionCollection;
use Playground\Lead\Models\Region;

/**
 * \Playground\Lead\Api\Http\Controllers\RegionController
 */
class RegionController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Region',
        'model_label_plural' => 'Regions',
        'model_route' => 'playground.lead.api.regions',
        'model_slug' => 'region',
        'model_slug_plural' => 'regions',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:region',
        'table' => 'lead_regions',
    ];

    /**
     * Create information for the Region resource in storage.
     *
     * @route GET /api/lead/regions/create playground.lead.api.regions.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|RegionResource {

        $validated = $request->validated();

        $region = new Region($validated);

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Region resource in storage.
     *
     * @route GET /api/lead/regions/edit playground.lead.api.regions.edit
     */
    public function edit(
        Region $region,
        EditRequest $request
    ): JsonResponse|RegionResource {
        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Region resource from storage.
     *
     * @route DELETE /api/lead/regions/{region} playground.lead.api.regions.destroy
     */
    public function destroy(
        Region $region,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $region->delete();
        } else {
            $region->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Region resource in storage.
     *
     * @route PUT /api/lead/regions/{region} playground.lead.api.regions.lock
     */
    public function lock(
        Region $region,
        LockRequest $request
    ): JsonResponse|RegionResource {
        $validated = $request->validated();

        $region->setAttribute('locked', true);

        $region->save();

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Region resources.
     *
     * @route GET /api/lead/regions playground.lead.api.regions
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|RegionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Region::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new RegionCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Region resource from the trash.
     *
     * @route PUT /api/lead/regions/restore/{region} playground.lead.api.regions.restore
     */
    public function restore(
        Region $region,
        RestoreRequest $request
    ): JsonResponse|RegionResource {
        $validated = $request->validated();

        $user = $request->user();

        $region->restore();

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Region resource.
     *
     * @route GET /api/lead/regions/{region} playground.lead.api.regions.show
     */
    public function show(
        Region $region,
        ShowRequest $request
    ): JsonResponse|RegionResource {
        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Region resource in storage.
     *
     * @route POST /api/lead/regions playground.lead.api.regions.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RegionResource {
        $validated = $request->validated();

        $user = $request->user();

        $region = new Region($validated);

        $region->created_by_id = $user?->id;

        $region->save();

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Region resource in storage.
     *
     * @route DELETE /api/lead/regions/lock/{region} playground.lead.api.regions.unlock
     */
    public function unlock(
        Region $region,
        UnlockRequest $request
    ): JsonResponse|RegionResource {
        $validated = $request->validated();

        $region->setAttribute('locked', false);

        $region->save();

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Region resource in storage.
     *
     * @route PATCH /api/lead/regions/{region} playground.lead.api.regions.patch
     */
    public function update(
        Region $region,
        UpdateRequest $request
    ): JsonResponse|RegionResource {
        $validated = $request->validated();

        $user = $request->user();

        $region->modified_by_id = $user?->id;

        $region->update($validated);

        return (new RegionResource($region))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

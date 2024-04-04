<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Source\CreateRequest;
use Playground\Lead\Api\Http\Requests\Source\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Source\EditRequest;
use Playground\Lead\Api\Http\Requests\Source\IndexRequest;
use Playground\Lead\Api\Http\Requests\Source\LockRequest;
use Playground\Lead\Api\Http\Requests\Source\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Source\ShowRequest;
use Playground\Lead\Api\Http\Requests\Source\StoreRequest;
use Playground\Lead\Api\Http\Requests\Source\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Source\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Source as SourceResource;
use Playground\Lead\Api\Http\Resources\SourceCollection;
use Playground\Lead\Models\Source;

/**
 * \Playground\Lead\Api\Http\Controllers\SourceController
 */
class SourceController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_route' => 'playground.lead.api.sources',
        'model_slug' => 'source',
        'model_slug_plural' => 'sources',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:source',
        'table' => 'lead_sources',
    ];

    /**
     * Create information for the Source resource in storage.
     *
     * @route GET /api/lead/sources/create playground.lead.api.sources.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|SourceResource {

        $validated = $request->validated();

        $source = new Source($validated);

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Source resource in storage.
     *
     * @route GET /api/lead/sources/edit playground.lead.api.sources.edit
     */
    public function edit(
        Source $source,
        EditRequest $request
    ): JsonResponse|SourceResource {
        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Source resource from storage.
     *
     * @route DELETE /api/lead/sources/{source} playground.lead.api.sources.destroy
     */
    public function destroy(
        Source $source,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $source->delete();
        } else {
            $source->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Source resource in storage.
     *
     * @route PUT /api/lead/sources/{source} playground.lead.api.sources.lock
     */
    public function lock(
        Source $source,
        LockRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $source->setAttribute('locked', true);

        $source->save();

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Source resources.
     *
     * @route GET /api/lead/sources playground.lead.api.sources
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|SourceCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Source::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new SourceCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Source resource from the trash.
     *
     * @route PUT /api/lead/sources/restore/{source} playground.lead.api.sources.restore
     */
    public function restore(
        Source $source,
        RestoreRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->restore();

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Source resource.
     *
     * @route GET /api/lead/sources/{source} playground.lead.api.sources.show
     */
    public function show(
        Source $source,
        ShowRequest $request
    ): JsonResponse|SourceResource {
        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Source resource in storage.
     *
     * @route POST /api/lead/sources playground.lead.api.sources.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        $source->created_by_id = $user?->id;

        $source->save();

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Source resource in storage.
     *
     * @route DELETE /api/lead/sources/lock/{source} playground.lead.api.sources.unlock
     */
    public function unlock(
        Source $source,
        UnlockRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $source->setAttribute('locked', false);

        $source->save();

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Source resource in storage.
     *
     * @route PATCH /api/lead/sources/{source} playground.lead.api.sources.patch
     */
    public function update(
        Source $source,
        UpdateRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->modified_by_id = $user?->id;

        $source->update($validated);

        return (new SourceResource($source))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

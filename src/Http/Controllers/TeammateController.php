<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Teammate\CreateRequest;
use Playground\Lead\Api\Http\Requests\Teammate\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Teammate\EditRequest;
use Playground\Lead\Api\Http\Requests\Teammate\IndexRequest;
use Playground\Lead\Api\Http\Requests\Teammate\LockRequest;
use Playground\Lead\Api\Http\Requests\Teammate\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Teammate\ShowRequest;
use Playground\Lead\Api\Http\Requests\Teammate\StoreRequest;
use Playground\Lead\Api\Http\Requests\Teammate\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Teammate\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Teammate as TeammateResource;
use Playground\Lead\Api\Http\Resources\TeammateCollection;
use Playground\Lead\Models\Teammate;

/**
 * \Playground\Lead\Api\Http\Controllers\TeammateController
 */
class TeammateController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Teammate',
        'model_label_plural' => 'Teammates',
        'model_route' => 'playground.lead.api.teammates',
        'model_slug' => 'teammate',
        'model_slug_plural' => 'teammates',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:teammate',
        'table' => 'lead_teammates',
    ];

    /**
     * Create information for the Teammate resource in storage.
     *
     * @route GET /api/lead/teammates/create playground.lead.api.teammates.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|TeammateResource {

        $validated = $request->validated();

        $teammate = new Teammate($validated);

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Teammate resource in storage.
     *
     * @route GET /api/lead/teammates/edit playground.lead.api.teammates.edit
     */
    public function edit(
        Teammate $teammate,
        EditRequest $request
    ): JsonResponse|TeammateResource {
        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Teammate resource from storage.
     *
     * @route DELETE /api/lead/teammates/{teammate} playground.lead.api.teammates.destroy
     */
    public function destroy(
        Teammate $teammate,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $teammate->delete();
        } else {
            $teammate->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Teammate resource in storage.
     *
     * @route PUT /api/lead/teammates/{teammate} playground.lead.api.teammates.lock
     */
    public function lock(
        Teammate $teammate,
        LockRequest $request
    ): JsonResponse|TeammateResource {
        $validated = $request->validated();

        $teammate->setAttribute('locked', true);

        $teammate->save();

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Teammate resources.
     *
     * @route GET /api/lead/teammates playground.lead.api.teammates
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TeammateCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Teammate::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new TeammateCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Teammate resource from the trash.
     *
     * @route PUT /api/lead/teammates/restore/{teammate} playground.lead.api.teammates.restore
     */
    public function restore(
        Teammate $teammate,
        RestoreRequest $request
    ): JsonResponse|TeammateResource {
        $validated = $request->validated();

        $user = $request->user();

        $teammate->restore();

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Teammate resource.
     *
     * @route GET /api/lead/teammates/{teammate} playground.lead.api.teammates.show
     */
    public function show(
        Teammate $teammate,
        ShowRequest $request
    ): JsonResponse|TeammateResource {
        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Teammate resource in storage.
     *
     * @route POST /api/lead/teammates playground.lead.api.teammates.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TeammateResource {
        $validated = $request->validated();

        $user = $request->user();

        $teammate = new Teammate($validated);

        $teammate->created_by_id = $user?->id;

        $teammate->save();

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Teammate resource in storage.
     *
     * @route DELETE /api/lead/teammates/lock/{teammate} playground.lead.api.teammates.unlock
     */
    public function unlock(
        Teammate $teammate,
        UnlockRequest $request
    ): JsonResponse|TeammateResource {
        $validated = $request->validated();

        $teammate->setAttribute('locked', false);

        $teammate->save();

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Teammate resource in storage.
     *
     * @route PATCH /api/lead/teammates/{teammate} playground.lead.api.teammates.patch
     */
    public function update(
        Teammate $teammate,
        UpdateRequest $request
    ): JsonResponse|TeammateResource {
        $validated = $request->validated();

        $user = $request->user();

        $teammate->modified_by_id = $user?->id;

        $teammate->update($validated);

        return (new TeammateResource($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

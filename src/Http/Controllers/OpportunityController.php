<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Opportunity\CreateRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\EditRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\IndexRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\LockRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\ShowRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\StoreRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Opportunity\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Opportunity as OpportunityResource;
use Playground\Lead\Api\Http\Resources\OpportunityCollection;
use Playground\Lead\Models\Opportunity;

/**
 * \Playground\Lead\Api\Http\Controllers\OpportunityController
 */
class OpportunityController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Opportunity',
        'model_label_plural' => 'Opportunities',
        'model_route' => 'playground.lead.api.opportunities',
        'model_slug' => 'opportunity',
        'model_slug_plural' => 'opportunities',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:opportunity',
        'table' => 'lead_opportunities',
    ];

    /**
     * Create information for the Opportunity resource in storage.
     *
     * @route GET /api/lead/opportunities/create playground.lead.api.opportunities.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|OpportunityResource {

        $validated = $request->validated();

        $opportunity = new Opportunity($validated);

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Opportunity resource in storage.
     *
     * @route GET /api/lead/opportunities/edit playground.lead.api.opportunities.edit
     */
    public function edit(
        Opportunity $opportunity,
        EditRequest $request
    ): JsonResponse|OpportunityResource {
        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Opportunity resource from storage.
     *
     * @route DELETE /api/lead/opportunities/{opportunity} playground.lead.api.opportunities.destroy
     */
    public function destroy(
        Opportunity $opportunity,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $opportunity->delete();
        } else {
            $opportunity->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Opportunity resource in storage.
     *
     * @route PUT /api/lead/opportunities/{opportunity} playground.lead.api.opportunities.lock
     */
    public function lock(
        Opportunity $opportunity,
        LockRequest $request
    ): JsonResponse|OpportunityResource {
        $validated = $request->validated();

        $opportunity->setAttribute('locked', true);

        $opportunity->save();

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Opportunity resources.
     *
     * @route GET /api/lead/opportunities playground.lead.api.opportunities
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|OpportunityCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Opportunity::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new OpportunityCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Opportunity resource from the trash.
     *
     * @route PUT /api/lead/opportunities/restore/{opportunity} playground.lead.api.opportunities.restore
     */
    public function restore(
        Opportunity $opportunity,
        RestoreRequest $request
    ): JsonResponse|OpportunityResource {
        $validated = $request->validated();

        $user = $request->user();

        $opportunity->restore();

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Opportunity resource.
     *
     * @route GET /api/lead/opportunities/{opportunity} playground.lead.api.opportunities.show
     */
    public function show(
        Opportunity $opportunity,
        ShowRequest $request
    ): JsonResponse|OpportunityResource {
        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Opportunity resource in storage.
     *
     * @route POST /api/lead/opportunities playground.lead.api.opportunities.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|OpportunityResource {
        $validated = $request->validated();

        $user = $request->user();

        $opportunity = new Opportunity($validated);

        $opportunity->created_by_id = $user?->id;

        $opportunity->save();

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Opportunity resource in storage.
     *
     * @route DELETE /api/lead/opportunities/lock/{opportunity} playground.lead.api.opportunities.unlock
     */
    public function unlock(
        Opportunity $opportunity,
        UnlockRequest $request
    ): JsonResponse|OpportunityResource {
        $validated = $request->validated();

        $opportunity->setAttribute('locked', false);

        $opportunity->save();

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Opportunity resource in storage.
     *
     * @route PATCH /api/lead/opportunities/{opportunity} playground.lead.api.opportunities.patch
     */
    public function update(
        Opportunity $opportunity,
        UpdateRequest $request
    ): JsonResponse|OpportunityResource {
        $validated = $request->validated();

        $user = $request->user();

        $opportunity->modified_by_id = $user?->id;

        $opportunity->update($validated);

        return (new OpportunityResource($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Lead\CreateRequest;
use Playground\Lead\Api\Http\Requests\Lead\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Lead\EditRequest;
use Playground\Lead\Api\Http\Requests\Lead\IndexRequest;
use Playground\Lead\Api\Http\Requests\Lead\LockRequest;
use Playground\Lead\Api\Http\Requests\Lead\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Lead\ShowRequest;
use Playground\Lead\Api\Http\Requests\Lead\StoreRequest;
use Playground\Lead\Api\Http\Requests\Lead\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Lead\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Lead as LeadResource;
use Playground\Lead\Api\Http\Resources\LeadCollection;
use Playground\Lead\Models\Lead;

/**
 * \Playground\Lead\Api\Http\Controllers\LeadController
 */
class LeadController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Lead',
        'model_label_plural' => 'Leads',
        'model_route' => 'playground.lead.api.leads',
        'model_slug' => 'lead',
        'model_slug_plural' => 'leads',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:lead',
        'table' => 'lead_leads',
    ];

    /**
     * Create information for the Lead resource in storage.
     *
     * @route GET /api/lead/leads/create playground.lead.api.leads.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|LeadResource {

        $validated = $request->validated();

        $lead = new Lead($validated);

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Lead resource in storage.
     *
     * @route GET /api/lead/leads/edit playground.lead.api.leads.edit
     */
    public function edit(
        Lead $lead,
        EditRequest $request
    ): JsonResponse|LeadResource {
        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Lead resource from storage.
     *
     * @route DELETE /api/lead/leads/{lead} playground.lead.api.leads.destroy
     */
    public function destroy(
        Lead $lead,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $lead->delete();
        } else {
            $lead->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Lead resource in storage.
     *
     * @route PUT /api/lead/leads/{lead} playground.lead.api.leads.lock
     */
    public function lock(
        Lead $lead,
        LockRequest $request
    ): JsonResponse|LeadResource {
        $validated = $request->validated();

        $lead->setAttribute('locked', true);

        $lead->save();

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Lead resources.
     *
     * @route GET /api/lead/leads playground.lead.api.leads
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|LeadCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Lead::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new LeadCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Lead resource from the trash.
     *
     * @route PUT /api/lead/leads/restore/{lead} playground.lead.api.leads.restore
     */
    public function restore(
        Lead $lead,
        RestoreRequest $request
    ): JsonResponse|LeadResource {
        $validated = $request->validated();

        $user = $request->user();

        $lead->restore();

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Lead resource.
     *
     * @route GET /api/lead/leads/{lead} playground.lead.api.leads.show
     */
    public function show(
        Lead $lead,
        ShowRequest $request
    ): JsonResponse|LeadResource {
        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Lead resource in storage.
     *
     * @route POST /api/lead/leads playground.lead.api.leads.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|LeadResource {
        $validated = $request->validated();

        $user = $request->user();

        $lead = new Lead($validated);

        $lead->created_by_id = $user?->id;

        $lead->save();

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Lead resource in storage.
     *
     * @route DELETE /api/lead/leads/lock/{lead} playground.lead.api.leads.unlock
     */
    public function unlock(
        Lead $lead,
        UnlockRequest $request
    ): JsonResponse|LeadResource {
        $validated = $request->validated();

        $lead->setAttribute('locked', false);

        $lead->save();

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Lead resource in storage.
     *
     * @route PATCH /api/lead/leads/{lead} playground.lead.api.leads.patch
     */
    public function update(
        Lead $lead,
        UpdateRequest $request
    ): JsonResponse|LeadResource {
        $validated = $request->validated();

        $user = $request->user();

        $lead->modified_by_id = $user?->id;

        $lead->update($validated);

        return (new LeadResource($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

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
        'model_attribute' => 'title',
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
     * Create the Lead resource in storage.
     *
     * @route GET /api/lead/leads/create playground.lead.api.leads.create
     */
    public function create(
        Requests\Lead\CreateRequest $request
    ): JsonResponse|Resources\Lead {

        $validated = $request->validated();

        $user = $request->user();

        $lead = new Lead($validated);

        return (new Resources\Lead($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Lead resource in storage.
     *
     * @route GET /api/lead/leads/edit playground.lead.api.leads.edit
     */
    public function edit(
        Lead $lead,
        Requests\Lead\EditRequest $request
    ): JsonResponse|Resources\Lead {
        return (new Resources\Lead($lead))->additional(['meta' => [
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
        Requests\Lead\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $lead->modified_by_id = $user->id;
        }

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
        Requests\Lead\LockRequest $request
    ): JsonResponse|Resources\Lead {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $lead->modified_by_id = $user->id;
        }

        $lead->locked = true;

        $lead->save();

        return (new Resources\Lead($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Lead resources.
     *
     * @route GET /api/lead/leads playground.lead.api.leads
     */
    public function index(
        Requests\Lead\IndexRequest $request
    ): JsonResponse|Resources\LeadCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\LeadCollection($paginator))->response($request);
    }

    /**
     * Restore the Lead resource from the trash.
     *
     * @route PUT /api/lead/leads/restore/{lead} playground.lead.api.leads.restore
     */
    public function restore(
        Lead $lead,
        Requests\Lead\RestoreRequest $request
    ): JsonResponse|Resources\Lead {

        $user = $request->user();

        if ($user?->id) {
            $lead->modified_by_id = $user->id;
        }

        $lead->restore();

        return (new Resources\Lead($lead))->additional(['meta' => [
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
        Requests\Lead\ShowRequest $request
    ): JsonResponse|Resources\Lead {
        return (new Resources\Lead($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Lead resource in storage.
     *
     * @route POST /api/lead/leads playground.lead.api.leads.post
     */
    public function store(
        Requests\Lead\StoreRequest $request
    ): Response|JsonResponse|Resources\Lead {
        $validated = $request->validated();

        $user = $request->user();

        $lead = new Lead($validated);

        $lead->created_by_id = $user?->id;

        $lead->save();

        return (new Resources\Lead($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Lead resource in storage.
     *
     * @route DELETE /api/lead/leads/lock/{lead} playground.lead.api.leads.unlock
     */
    public function unlock(
        Lead $lead,
        Requests\Lead\UnlockRequest $request
    ): JsonResponse|Resources\Lead {

        $validated = $request->validated();

        $user = $request->user();

        $lead->locked = false;

        if ($user?->id) {
            $lead->modified_by_id = $user->id;
        }

        $lead->save();

        return (new Resources\Lead($lead))->additional(['meta' => [
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
        Requests\Lead\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $lead->modified_by_id = $user->id;
        }

        $lead->update($validated);

        return (new Resources\Lead($lead))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

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
        'model_attribute' => 'title',
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
     * Create the Opportunity resource in storage.
     *
     * @route GET /api/lead/opportunities/create playground.lead.api.opportunities.create
     */
    public function create(
        Requests\Opportunity\CreateRequest $request
    ): JsonResponse|Resources\Opportunity {

        $validated = $request->validated();

        $user = $request->user();

        $opportunity = new Opportunity($validated);

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Opportunity resource in storage.
     *
     * @route GET /api/lead/opportunities/edit playground.lead.api.opportunities.edit
     */
    public function edit(
        Opportunity $opportunity,
        Requests\Opportunity\EditRequest $request
    ): JsonResponse|Resources\Opportunity {
        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
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
        Requests\Opportunity\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $opportunity->modified_by_id = $user->id;
        }

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
        Requests\Opportunity\LockRequest $request
    ): JsonResponse|Resources\Opportunity {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $opportunity->modified_by_id = $user->id;
        }

        $opportunity->locked = true;

        $opportunity->save();

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Opportunity resources.
     *
     * @route GET /api/lead/opportunities playground.lead.api.opportunities
     */
    public function index(
        Requests\Opportunity\IndexRequest $request
    ): JsonResponse|Resources\OpportunityCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\OpportunityCollection($paginator))->response($request);
    }

    /**
     * Restore the Opportunity resource from the trash.
     *
     * @route PUT /api/lead/opportunities/restore/{opportunity} playground.lead.api.opportunities.restore
     */
    public function restore(
        Opportunity $opportunity,
        Requests\Opportunity\RestoreRequest $request
    ): JsonResponse|Resources\Opportunity {

        $user = $request->user();

        if ($user?->id) {
            $opportunity->modified_by_id = $user->id;
        }

        $opportunity->restore();

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
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
        Requests\Opportunity\ShowRequest $request
    ): JsonResponse|Resources\Opportunity {
        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Opportunity resource in storage.
     *
     * @route POST /api/lead/opportunities playground.lead.api.opportunities.post
     */
    public function store(
        Requests\Opportunity\StoreRequest $request
    ): Response|JsonResponse|Resources\Opportunity {
        $validated = $request->validated();

        $user = $request->user();

        $opportunity = new Opportunity($validated);

        $opportunity->created_by_id = $user?->id;

        $opportunity->save();

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Opportunity resource in storage.
     *
     * @route DELETE /api/lead/opportunities/lock/{opportunity} playground.lead.api.opportunities.unlock
     */
    public function unlock(
        Opportunity $opportunity,
        Requests\Opportunity\UnlockRequest $request
    ): JsonResponse|Resources\Opportunity {

        $validated = $request->validated();

        $user = $request->user();

        $opportunity->locked = false;

        if ($user?->id) {
            $opportunity->modified_by_id = $user->id;
        }

        $opportunity->save();

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
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
        Requests\Opportunity\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $opportunity->modified_by_id = $user->id;
        }

        $opportunity->update($validated);

        return (new Resources\Opportunity($opportunity))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

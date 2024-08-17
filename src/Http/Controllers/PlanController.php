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
use Playground\Lead\Models\Plan;

/**
 * \Playground\Lead\Api\Http\Controllers\PlanController
 */
class PlanController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Plan',
        'model_label_plural' => 'Plans',
        'model_route' => 'playground.lead.api.plans',
        'model_slug' => 'plan',
        'model_slug_plural' => 'plans',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:plan',
        'table' => 'lead_plans',
    ];

    /**
     * Create the Plan resource in storage.
     *
     * @route GET /api/lead/plans/create playground.lead.api.plans.create
     */
    public function create(
        Requests\Plan\CreateRequest $request
    ): JsonResponse|Resources\Plan {

        $validated = $request->validated();

        $user = $request->user();

        $plan = new Plan($validated);

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Plan resource in storage.
     *
     * @route GET /api/lead/plans/edit playground.lead.api.plans.edit
     */
    public function edit(
        Plan $plan,
        Requests\Plan\EditRequest $request
    ): JsonResponse|Resources\Plan {
        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Plan resource from storage.
     *
     * @route DELETE /api/lead/plans/{plan} playground.lead.api.plans.destroy
     */
    public function destroy(
        Plan $plan,
        Requests\Plan\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $plan->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $plan->delete();
        } else {
            $plan->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Plan resource in storage.
     *
     * @route PUT /api/lead/plans/{plan} playground.lead.api.plans.lock
     */
    public function lock(
        Plan $plan,
        Requests\Plan\LockRequest $request
    ): JsonResponse|Resources\Plan {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $plan->modified_by_id = $user->id;
        }

        $plan->locked = true;

        $plan->save();

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Plan resources.
     *
     * @route GET /api/lead/plans playground.lead.api.plans
     */
    public function index(
        Requests\Plan\IndexRequest $request
    ): JsonResponse|Resources\PlanCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Plan::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\PlanCollection($paginator))->response($request);
    }

    /**
     * Restore the Plan resource from the trash.
     *
     * @route PUT /api/lead/plans/restore/{plan} playground.lead.api.plans.restore
     */
    public function restore(
        Plan $plan,
        Requests\Plan\RestoreRequest $request
    ): JsonResponse|Resources\Plan {

        $user = $request->user();

        if ($user?->id) {
            $plan->modified_by_id = $user->id;
        }

        $plan->restore();

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Plan resource.
     *
     * @route GET /api/lead/plans/{plan} playground.lead.api.plans.show
     */
    public function show(
        Plan $plan,
        Requests\Plan\ShowRequest $request
    ): JsonResponse|Resources\Plan {
        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Plan resource in storage.
     *
     * @route POST /api/lead/plans playground.lead.api.plans.post
     */
    public function store(
        Requests\Plan\StoreRequest $request
    ): Response|JsonResponse|Resources\Plan {
        $validated = $request->validated();

        $user = $request->user();

        $plan = new Plan($validated);

        $plan->created_by_id = $user?->id;

        $plan->save();

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Plan resource in storage.
     *
     * @route DELETE /api/lead/plans/lock/{plan} playground.lead.api.plans.unlock
     */
    public function unlock(
        Plan $plan,
        Requests\Plan\UnlockRequest $request
    ): JsonResponse|Resources\Plan {

        $validated = $request->validated();

        $user = $request->user();

        $plan->locked = false;

        if ($user?->id) {
            $plan->modified_by_id = $user->id;
        }

        $plan->save();

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Plan resource in storage.
     *
     * @route PATCH /api/lead/plans/{plan} playground.lead.api.plans.patch
     */
    public function update(
        Plan $plan,
        Requests\Plan\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $plan->modified_by_id = $user->id;
        }

        $plan->update($validated);

        return (new Resources\Plan($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

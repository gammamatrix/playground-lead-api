<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Plan\CreateRequest;
use Playground\Lead\Api\Http\Requests\Plan\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Plan\EditRequest;
use Playground\Lead\Api\Http\Requests\Plan\IndexRequest;
use Playground\Lead\Api\Http\Requests\Plan\LockRequest;
use Playground\Lead\Api\Http\Requests\Plan\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Plan\ShowRequest;
use Playground\Lead\Api\Http\Requests\Plan\StoreRequest;
use Playground\Lead\Api\Http\Requests\Plan\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Plan\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Plan as PlanResource;
use Playground\Lead\Api\Http\Resources\PlanCollection;
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
        'model_attribute' => 'label',
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
     * Create information for the Plan resource in storage.
     *
     * @route GET /api/lead/plans/create playground.lead.api.plans.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|PlanResource {

        $validated = $request->validated();

        $plan = new Plan($validated);

        return (new PlanResource($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Plan resource in storage.
     *
     * @route GET /api/lead/plans/edit playground.lead.api.plans.edit
     */
    public function edit(
        Plan $plan,
        EditRequest $request
    ): JsonResponse|PlanResource {
        return (new PlanResource($plan))->additional(['meta' => [
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
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
        LockRequest $request
    ): JsonResponse|PlanResource {
        $validated = $request->validated();

        $plan->setAttribute('locked', true);

        $plan->save();

        return (new PlanResource($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Plan resources.
     *
     * @route GET /api/lead/plans playground.lead.api.plans
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|PlanCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new PlanCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Plan resource from the trash.
     *
     * @route PUT /api/lead/plans/restore/{plan} playground.lead.api.plans.restore
     */
    public function restore(
        Plan $plan,
        RestoreRequest $request
    ): JsonResponse|PlanResource {
        $validated = $request->validated();

        $user = $request->user();

        $plan->restore();

        return (new PlanResource($plan))->additional(['meta' => [
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
        ShowRequest $request
    ): JsonResponse|PlanResource {
        return (new PlanResource($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Plan resource in storage.
     *
     * @route POST /api/lead/plans playground.lead.api.plans.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|PlanResource {
        $validated = $request->validated();

        $user = $request->user();

        $plan = new Plan($validated);

        $plan->created_by_id = $user?->id;

        $plan->save();

        return (new PlanResource($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Plan resource in storage.
     *
     * @route DELETE /api/lead/plans/lock/{plan} playground.lead.api.plans.unlock
     */
    public function unlock(
        Plan $plan,
        UnlockRequest $request
    ): JsonResponse|PlanResource {
        $validated = $request->validated();

        $plan->setAttribute('locked', false);

        $plan->save();

        return (new PlanResource($plan))->additional(['meta' => [
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
        UpdateRequest $request
    ): JsonResponse|PlanResource {
        $validated = $request->validated();

        $user = $request->user();

        $plan->modified_by_id = $user?->id;

        $plan->update($validated);

        return (new PlanResource($plan))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

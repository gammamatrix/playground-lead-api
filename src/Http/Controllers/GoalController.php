<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Goal\CreateRequest;
use Playground\Lead\Api\Http\Requests\Goal\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Goal\EditRequest;
use Playground\Lead\Api\Http\Requests\Goal\IndexRequest;
use Playground\Lead\Api\Http\Requests\Goal\LockRequest;
use Playground\Lead\Api\Http\Requests\Goal\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Goal\ShowRequest;
use Playground\Lead\Api\Http\Requests\Goal\StoreRequest;
use Playground\Lead\Api\Http\Requests\Goal\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Goal\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Goal as GoalResource;
use Playground\Lead\Api\Http\Resources\GoalCollection;
use Playground\Lead\Models\Goal;

/**
 * \Playground\Lead\Api\Http\Controllers\GoalController
 */
class GoalController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Goal',
        'model_label_plural' => 'Goals',
        'model_route' => 'playground.lead.api.goals',
        'model_slug' => 'goal',
        'model_slug_plural' => 'goals',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:goal',
        'table' => 'lead_goals',
    ];

    /**
     * Create information for the Goal resource in storage.
     *
     * @route GET /api/lead/goals/create playground.lead.api.goals.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|GoalResource {

        $validated = $request->validated();

        $goal = new Goal($validated);

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Goal resource in storage.
     *
     * @route GET /api/lead/goals/edit playground.lead.api.goals.edit
     */
    public function edit(
        Goal $goal,
        EditRequest $request
    ): JsonResponse|GoalResource {
        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Goal resource from storage.
     *
     * @route DELETE /api/lead/goals/{goal} playground.lead.api.goals.destroy
     */
    public function destroy(
        Goal $goal,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $goal->delete();
        } else {
            $goal->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Goal resource in storage.
     *
     * @route PUT /api/lead/goals/{goal} playground.lead.api.goals.lock
     */
    public function lock(
        Goal $goal,
        LockRequest $request
    ): JsonResponse|GoalResource {
        $validated = $request->validated();

        $goal->setAttribute('locked', true);

        $goal->save();

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Goal resources.
     *
     * @route GET /api/lead/goals playground.lead.api.goals
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|GoalCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Goal::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new GoalCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Goal resource from the trash.
     *
     * @route PUT /api/lead/goals/restore/{goal} playground.lead.api.goals.restore
     */
    public function restore(
        Goal $goal,
        RestoreRequest $request
    ): JsonResponse|GoalResource {
        $validated = $request->validated();

        $user = $request->user();

        $goal->restore();

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Goal resource.
     *
     * @route GET /api/lead/goals/{goal} playground.lead.api.goals.show
     */
    public function show(
        Goal $goal,
        ShowRequest $request
    ): JsonResponse|GoalResource {
        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Goal resource in storage.
     *
     * @route POST /api/lead/goals playground.lead.api.goals.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|GoalResource {
        $validated = $request->validated();

        $user = $request->user();

        $goal = new Goal($validated);

        $goal->created_by_id = $user?->id;

        $goal->save();

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Goal resource in storage.
     *
     * @route DELETE /api/lead/goals/lock/{goal} playground.lead.api.goals.unlock
     */
    public function unlock(
        Goal $goal,
        UnlockRequest $request
    ): JsonResponse|GoalResource {
        $validated = $request->validated();

        $goal->setAttribute('locked', false);

        $goal->save();

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Goal resource in storage.
     *
     * @route PATCH /api/lead/goals/{goal} playground.lead.api.goals.patch
     */
    public function update(
        Goal $goal,
        UpdateRequest $request
    ): JsonResponse|GoalResource {
        $validated = $request->validated();

        $user = $request->user();

        $goal->modified_by_id = $user?->id;

        $goal->update($validated);

        return (new GoalResource($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

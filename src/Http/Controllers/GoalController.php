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
        'model_attribute' => 'title',
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
     * Create the Goal resource in storage.
     *
     * @route GET /api/lead/goals/create playground.lead.api.goals.create
     */
    public function create(
        Requests\Goal\CreateRequest $request
    ): JsonResponse|Resources\Goal {

        $validated = $request->validated();

        $user = $request->user();

        $goal = new Goal($validated);

        return (new Resources\Goal($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Goal resource in storage.
     *
     * @route GET /api/lead/goals/edit playground.lead.api.goals.edit
     */
    public function edit(
        Goal $goal,
        Requests\Goal\EditRequest $request
    ): JsonResponse|Resources\Goal {
        return (new Resources\Goal($goal))->additional(['meta' => [
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
        Requests\Goal\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $goal->modified_by_id = $user->id;
        }

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
        Requests\Goal\LockRequest $request
    ): JsonResponse|Resources\Goal {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $goal->modified_by_id = $user->id;
        }

        $goal->locked = true;

        $goal->save();

        return (new Resources\Goal($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Goal resources.
     *
     * @route GET /api/lead/goals playground.lead.api.goals
     */
    public function index(
        Requests\Goal\IndexRequest $request
    ): JsonResponse|Resources\GoalCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\GoalCollection($paginator))->response($request);
    }

    /**
     * Restore the Goal resource from the trash.
     *
     * @route PUT /api/lead/goals/restore/{goal} playground.lead.api.goals.restore
     */
    public function restore(
        Goal $goal,
        Requests\Goal\RestoreRequest $request
    ): JsonResponse|Resources\Goal {

        $user = $request->user();

        if ($user?->id) {
            $goal->modified_by_id = $user->id;
        }

        $goal->restore();

        return (new Resources\Goal($goal))->additional(['meta' => [
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
        Requests\Goal\ShowRequest $request
    ): JsonResponse|Resources\Goal {
        return (new Resources\Goal($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Goal resource in storage.
     *
     * @route POST /api/lead/goals playground.lead.api.goals.post
     */
    public function store(
        Requests\Goal\StoreRequest $request
    ): Response|JsonResponse|Resources\Goal {
        $validated = $request->validated();

        $user = $request->user();

        $goal = new Goal($validated);

        $goal->created_by_id = $user?->id;

        $goal->save();

        return (new Resources\Goal($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Goal resource in storage.
     *
     * @route DELETE /api/lead/goals/lock/{goal} playground.lead.api.goals.unlock
     */
    public function unlock(
        Goal $goal,
        Requests\Goal\UnlockRequest $request
    ): JsonResponse|Resources\Goal {

        $validated = $request->validated();

        $user = $request->user();

        $goal->locked = false;

        if ($user?->id) {
            $goal->modified_by_id = $user->id;
        }

        $goal->save();

        return (new Resources\Goal($goal))->additional(['meta' => [
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
        Requests\Goal\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $goal->modified_by_id = $user->id;
        }

        $goal->update($validated);

        return (new Resources\Goal($goal))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

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
use Playground\Lead\Models\Team;

/**
 * \Playground\Lead\Api\Http\Controllers\TeamController
 */
class TeamController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Team',
        'model_label_plural' => 'Teams',
        'model_route' => 'playground.lead.api.teams',
        'model_slug' => 'team',
        'model_slug_plural' => 'teams',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:team',
        'table' => 'lead_teams',
    ];

    /**
     * Create the Team resource in storage.
     *
     * @route GET /api/lead/teams/create playground.lead.api.teams.create
     */
    public function create(
        Requests\Team\CreateRequest $request
    ): JsonResponse|Resources\Team {

        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Team resource in storage.
     *
     * @route GET /api/lead/teams/edit playground.lead.api.teams.edit
     */
    public function edit(
        Team $team,
        Requests\Team\EditRequest $request
    ): JsonResponse|Resources\Team {
        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Team resource from storage.
     *
     * @route DELETE /api/lead/teams/{team} playground.lead.api.teams.destroy
     */
    public function destroy(
        Team $team,
        Requests\Team\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $team->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $team->delete();
        } else {
            $team->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Team resource in storage.
     *
     * @route PUT /api/lead/teams/{team} playground.lead.api.teams.lock
     */
    public function lock(
        Team $team,
        Requests\Team\LockRequest $request
    ): JsonResponse|Resources\Team {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $team->modified_by_id = $user->id;
        }

        $team->locked = true;

        $team->save();

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Team resources.
     *
     * @route GET /api/lead/teams playground.lead.api.teams
     */
    public function index(
        Requests\Team\IndexRequest $request
    ): JsonResponse|Resources\TeamCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Team::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\TeamCollection($paginator))->response($request);
    }

    /**
     * Restore the Team resource from the trash.
     *
     * @route PUT /api/lead/teams/restore/{team} playground.lead.api.teams.restore
     */
    public function restore(
        Team $team,
        Requests\Team\RestoreRequest $request
    ): JsonResponse|Resources\Team {

        $user = $request->user();

        if ($user?->id) {
            $team->modified_by_id = $user->id;
        }

        $team->restore();

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Team resource.
     *
     * @route GET /api/lead/teams/{team} playground.lead.api.teams.show
     */
    public function show(
        Team $team,
        Requests\Team\ShowRequest $request
    ): JsonResponse|Resources\Team {
        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Team resource in storage.
     *
     * @route POST /api/lead/teams playground.lead.api.teams.post
     */
    public function store(
        Requests\Team\StoreRequest $request
    ): Response|JsonResponse|Resources\Team {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

        $team->created_by_id = $user?->id;

        $team->save();

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Team resource in storage.
     *
     * @route DELETE /api/lead/teams/lock/{team} playground.lead.api.teams.unlock
     */
    public function unlock(
        Team $team,
        Requests\Team\UnlockRequest $request
    ): JsonResponse|Resources\Team {

        $validated = $request->validated();

        $user = $request->user();

        $team->locked = false;

        if ($user?->id) {
            $team->modified_by_id = $user->id;
        }

        $team->save();

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Team resource in storage.
     *
     * @route PATCH /api/lead/teams/{team} playground.lead.api.teams.patch
     */
    public function update(
        Team $team,
        Requests\Team\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $team->modified_by_id = $user->id;
        }

        $team->update($validated);

        return (new Resources\Team($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

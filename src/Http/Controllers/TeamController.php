<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Team\CreateRequest;
use Playground\Lead\Api\Http\Requests\Team\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Team\EditRequest;
use Playground\Lead\Api\Http\Requests\Team\IndexRequest;
use Playground\Lead\Api\Http\Requests\Team\LockRequest;
use Playground\Lead\Api\Http\Requests\Team\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Team\ShowRequest;
use Playground\Lead\Api\Http\Requests\Team\StoreRequest;
use Playground\Lead\Api\Http\Requests\Team\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Team\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Team as TeamResource;
use Playground\Lead\Api\Http\Resources\TeamCollection;
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
        'model_attribute' => 'label',
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
     * Create information for the Team resource in storage.
     *
     * @route GET /api/lead/teams/create playground.lead.api.teams.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|TeamResource {

        $validated = $request->validated();

        $team = new Team($validated);

        return (new TeamResource($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Team resource in storage.
     *
     * @route GET /api/lead/teams/edit playground.lead.api.teams.edit
     */
    public function edit(
        Team $team,
        EditRequest $request
    ): JsonResponse|TeamResource {
        return (new TeamResource($team))->additional(['meta' => [
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
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
        LockRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $team->setAttribute('locked', true);

        $team->save();

        return (new TeamResource($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Team resources.
     *
     * @route GET /api/lead/teams playground.lead.api.teams
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TeamCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new TeamCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Team resource from the trash.
     *
     * @route PUT /api/lead/teams/restore/{team} playground.lead.api.teams.restore
     */
    public function restore(
        Team $team,
        RestoreRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->restore();

        return (new TeamResource($team))->additional(['meta' => [
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
        ShowRequest $request
    ): JsonResponse|TeamResource {
        return (new TeamResource($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Team resource in storage.
     *
     * @route POST /api/lead/teams playground.lead.api.teams.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

        $team->created_by_id = $user?->id;

        $team->save();

        return (new TeamResource($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Team resource in storage.
     *
     * @route DELETE /api/lead/teams/lock/{team} playground.lead.api.teams.unlock
     */
    public function unlock(
        Team $team,
        UnlockRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $team->setAttribute('locked', false);

        $team->save();

        return (new TeamResource($team))->additional(['meta' => [
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
        UpdateRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->modified_by_id = $user?->id;

        $team->update($validated);

        return (new TeamResource($team))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

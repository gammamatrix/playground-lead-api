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
use Playground\Lead\Models\Teammate;

/**
 * \Playground\Lead\Api\Http\Controllers\TeammateController
 */
class TeammateController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Teammate',
        'model_label_plural' => 'Teammates',
        'model_route' => 'playground.lead.api.teammates',
        'model_slug' => 'teammate',
        'model_slug_plural' => 'teammates',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:teammate',
        'table' => 'lead_teammates',
    ];

    /**
     * Create the Teammate resource in storage.
     *
     * @route GET /api/lead/teammates/create playground.lead.api.teammates.create
     */
    public function create(
        Requests\Teammate\CreateRequest $request
    ): JsonResponse|Resources\Teammate {

        $validated = $request->validated();

        $user = $request->user();

        $teammate = new Teammate($validated);

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Teammate resource in storage.
     *
     * @route GET /api/lead/teammates/edit playground.lead.api.teammates.edit
     */
    public function edit(
        Teammate $teammate,
        Requests\Teammate\EditRequest $request
    ): JsonResponse|Resources\Teammate {
        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Teammate resource from storage.
     *
     * @route DELETE /api/lead/teammates/{teammate} playground.lead.api.teammates.destroy
     */
    public function destroy(
        Teammate $teammate,
        Requests\Teammate\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $teammate->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $teammate->delete();
        } else {
            $teammate->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Teammate resource in storage.
     *
     * @route PUT /api/lead/teammates/{teammate} playground.lead.api.teammates.lock
     */
    public function lock(
        Teammate $teammate,
        Requests\Teammate\LockRequest $request
    ): JsonResponse|Resources\Teammate {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $teammate->modified_by_id = $user->id;
        }

        $teammate->locked = true;

        $teammate->save();

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Teammate resources.
     *
     * @route GET /api/lead/teammates playground.lead.api.teammates
     */
    public function index(
        Requests\Teammate\IndexRequest $request
    ): JsonResponse|Resources\TeammateCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Teammate::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\TeammateCollection($paginator))->response($request);
    }

    /**
     * Restore the Teammate resource from the trash.
     *
     * @route PUT /api/lead/teammates/restore/{teammate} playground.lead.api.teammates.restore
     */
    public function restore(
        Teammate $teammate,
        Requests\Teammate\RestoreRequest $request
    ): JsonResponse|Resources\Teammate {

        $user = $request->user();

        if ($user?->id) {
            $teammate->modified_by_id = $user->id;
        }

        $teammate->restore();

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Teammate resource.
     *
     * @route GET /api/lead/teammates/{teammate} playground.lead.api.teammates.show
     */
    public function show(
        Teammate $teammate,
        Requests\Teammate\ShowRequest $request
    ): JsonResponse|Resources\Teammate {
        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Teammate resource in storage.
     *
     * @route POST /api/lead/teammates playground.lead.api.teammates.post
     */
    public function store(
        Requests\Teammate\StoreRequest $request
    ): Response|JsonResponse|Resources\Teammate {
        $validated = $request->validated();

        $user = $request->user();

        $teammate = new Teammate($validated);

        $teammate->created_by_id = $user?->id;

        $teammate->save();

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Teammate resource in storage.
     *
     * @route DELETE /api/lead/teammates/lock/{teammate} playground.lead.api.teammates.unlock
     */
    public function unlock(
        Teammate $teammate,
        Requests\Teammate\UnlockRequest $request
    ): JsonResponse|Resources\Teammate {

        $validated = $request->validated();

        $user = $request->user();

        $teammate->locked = false;

        if ($user?->id) {
            $teammate->modified_by_id = $user->id;
        }

        $teammate->save();

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Teammate resource in storage.
     *
     * @route PATCH /api/lead/teammates/{teammate} playground.lead.api.teammates.patch
     */
    public function update(
        Teammate $teammate,
        Requests\Teammate\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $teammate->modified_by_id = $user->id;
        }

        $teammate->update($validated);

        return (new Resources\Teammate($teammate))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

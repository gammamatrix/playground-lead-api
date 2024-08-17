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
use Playground\Lead\Models\Campaign;

/**
 * \Playground\Lead\Api\Http\Controllers\CampaignController
 */
class CampaignController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Campaign',
        'model_label_plural' => 'Campaigns',
        'model_route' => 'playground.lead.api.campaigns',
        'model_slug' => 'campaign',
        'model_slug_plural' => 'campaigns',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:campaign',
        'table' => 'lead_campaigns',
    ];

    /**
     * Create the Campaign resource in storage.
     *
     * @route GET /api/lead/campaigns/create playground.lead.api.campaigns.create
     */
    public function create(
        Requests\Campaign\CreateRequest $request
    ): JsonResponse|Resources\Campaign {

        $validated = $request->validated();

        $user = $request->user();

        $campaign = new Campaign($validated);

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Campaign resource in storage.
     *
     * @route GET /api/lead/campaigns/edit playground.lead.api.campaigns.edit
     */
    public function edit(
        Campaign $campaign,
        Requests\Campaign\EditRequest $request
    ): JsonResponse|Resources\Campaign {
        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Campaign resource from storage.
     *
     * @route DELETE /api/lead/campaigns/{campaign} playground.lead.api.campaigns.destroy
     */
    public function destroy(
        Campaign $campaign,
        Requests\Campaign\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $campaign->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $campaign->delete();
        } else {
            $campaign->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Campaign resource in storage.
     *
     * @route PUT /api/lead/campaigns/{campaign} playground.lead.api.campaigns.lock
     */
    public function lock(
        Campaign $campaign,
        Requests\Campaign\LockRequest $request
    ): JsonResponse|Resources\Campaign {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $campaign->modified_by_id = $user->id;
        }

        $campaign->locked = true;

        $campaign->save();

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Campaign resources.
     *
     * @route GET /api/lead/campaigns playground.lead.api.campaigns
     */
    public function index(
        Requests\Campaign\IndexRequest $request
    ): JsonResponse|Resources\CampaignCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Campaign::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\CampaignCollection($paginator))->response($request);
    }

    /**
     * Restore the Campaign resource from the trash.
     *
     * @route PUT /api/lead/campaigns/restore/{campaign} playground.lead.api.campaigns.restore
     */
    public function restore(
        Campaign $campaign,
        Requests\Campaign\RestoreRequest $request
    ): JsonResponse|Resources\Campaign {

        $user = $request->user();

        if ($user?->id) {
            $campaign->modified_by_id = $user->id;
        }

        $campaign->restore();

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Campaign resource.
     *
     * @route GET /api/lead/campaigns/{campaign} playground.lead.api.campaigns.show
     */
    public function show(
        Campaign $campaign,
        Requests\Campaign\ShowRequest $request
    ): JsonResponse|Resources\Campaign {
        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Campaign resource in storage.
     *
     * @route POST /api/lead/campaigns playground.lead.api.campaigns.post
     */
    public function store(
        Requests\Campaign\StoreRequest $request
    ): Response|JsonResponse|Resources\Campaign {
        $validated = $request->validated();

        $user = $request->user();

        $campaign = new Campaign($validated);

        $campaign->created_by_id = $user?->id;

        $campaign->save();

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Campaign resource in storage.
     *
     * @route DELETE /api/lead/campaigns/lock/{campaign} playground.lead.api.campaigns.unlock
     */
    public function unlock(
        Campaign $campaign,
        Requests\Campaign\UnlockRequest $request
    ): JsonResponse|Resources\Campaign {

        $validated = $request->validated();

        $user = $request->user();

        $campaign->locked = false;

        if ($user?->id) {
            $campaign->modified_by_id = $user->id;
        }

        $campaign->save();

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Campaign resource in storage.
     *
     * @route PATCH /api/lead/campaigns/{campaign} playground.lead.api.campaigns.patch
     */
    public function update(
        Campaign $campaign,
        Requests\Campaign\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $campaign->modified_by_id = $user->id;
        }

        $campaign->update($validated);

        return (new Resources\Campaign($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

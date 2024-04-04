<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Campaign\CreateRequest;
use Playground\Lead\Api\Http\Requests\Campaign\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Campaign\EditRequest;
use Playground\Lead\Api\Http\Requests\Campaign\IndexRequest;
use Playground\Lead\Api\Http\Requests\Campaign\LockRequest;
use Playground\Lead\Api\Http\Requests\Campaign\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Campaign\ShowRequest;
use Playground\Lead\Api\Http\Requests\Campaign\StoreRequest;
use Playground\Lead\Api\Http\Requests\Campaign\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Campaign\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Campaign as CampaignResource;
use Playground\Lead\Api\Http\Resources\CampaignCollection;
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
        'model_attribute' => 'label',
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
     * Create information for the Campaign resource in storage.
     *
     * @route GET /api/lead/campaigns/create playground.lead.api.campaigns.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|CampaignResource {

        $validated = $request->validated();

        $campaign = new Campaign($validated);

        return (new CampaignResource($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Campaign resource in storage.
     *
     * @route GET /api/lead/campaigns/edit playground.lead.api.campaigns.edit
     */
    public function edit(
        Campaign $campaign,
        EditRequest $request
    ): JsonResponse|CampaignResource {
        return (new CampaignResource($campaign))->additional(['meta' => [
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
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
        LockRequest $request
    ): JsonResponse|CampaignResource {
        $validated = $request->validated();

        $campaign->setAttribute('locked', true);

        $campaign->save();

        return (new CampaignResource($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Campaign resources.
     *
     * @route GET /api/lead/campaigns playground.lead.api.campaigns
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|CampaignCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new CampaignCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Campaign resource from the trash.
     *
     * @route PUT /api/lead/campaigns/restore/{campaign} playground.lead.api.campaigns.restore
     */
    public function restore(
        Campaign $campaign,
        RestoreRequest $request
    ): JsonResponse|CampaignResource {
        $validated = $request->validated();

        $user = $request->user();

        $campaign->restore();

        return (new CampaignResource($campaign))->additional(['meta' => [
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
        ShowRequest $request
    ): JsonResponse|CampaignResource {
        return (new CampaignResource($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Campaign resource in storage.
     *
     * @route POST /api/lead/campaigns playground.lead.api.campaigns.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|CampaignResource {
        $validated = $request->validated();

        $user = $request->user();

        $campaign = new Campaign($validated);

        $campaign->created_by_id = $user?->id;

        $campaign->save();

        return (new CampaignResource($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Campaign resource in storage.
     *
     * @route DELETE /api/lead/campaigns/lock/{campaign} playground.lead.api.campaigns.unlock
     */
    public function unlock(
        Campaign $campaign,
        UnlockRequest $request
    ): JsonResponse|CampaignResource {
        $validated = $request->validated();

        $campaign->setAttribute('locked', false);

        $campaign->save();

        return (new CampaignResource($campaign))->additional(['meta' => [
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
        UpdateRequest $request
    ): JsonResponse|CampaignResource {
        $validated = $request->validated();

        $user = $request->user();

        $campaign->modified_by_id = $user?->id;

        $campaign->update($validated);

        return (new CampaignResource($campaign))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

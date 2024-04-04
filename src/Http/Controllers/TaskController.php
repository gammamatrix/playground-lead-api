<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Lead\Api\Http\Requests\Task\CreateRequest;
use Playground\Lead\Api\Http\Requests\Task\DestroyRequest;
use Playground\Lead\Api\Http\Requests\Task\EditRequest;
use Playground\Lead\Api\Http\Requests\Task\IndexRequest;
use Playground\Lead\Api\Http\Requests\Task\LockRequest;
use Playground\Lead\Api\Http\Requests\Task\RestoreRequest;
use Playground\Lead\Api\Http\Requests\Task\ShowRequest;
use Playground\Lead\Api\Http\Requests\Task\StoreRequest;
use Playground\Lead\Api\Http\Requests\Task\UnlockRequest;
use Playground\Lead\Api\Http\Requests\Task\UpdateRequest;
use Playground\Lead\Api\Http\Resources\Task as TaskResource;
use Playground\Lead\Api\Http\Resources\TaskCollection;
use Playground\Lead\Models\Task;

/**
 * \Playground\Lead\Api\Http\Controllers\TaskController
 */
class TaskController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Task',
        'model_label_plural' => 'Tasks',
        'model_route' => 'playground.lead.api.tasks',
        'model_slug' => 'task',
        'model_slug_plural' => 'tasks',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'privilege' => 'playground-lead-api:task',
        'table' => 'lead_tasks',
    ];

    /**
     * Create information for the Task resource in storage.
     *
     * @route GET /api/lead/tasks/create playground.lead.api.tasks.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|TaskResource {

        $validated = $request->validated();

        $task = new Task($validated);

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Task resource in storage.
     *
     * @route GET /api/lead/tasks/edit playground.lead.api.tasks.edit
     */
    public function edit(
        Task $task,
        EditRequest $request
    ): JsonResponse|TaskResource {
        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Task resource from storage.
     *
     * @route DELETE /api/lead/tasks/{task} playground.lead.api.tasks.destroy
     */
    public function destroy(
        Task $task,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $task->delete();
        } else {
            $task->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Task resource in storage.
     *
     * @route PUT /api/lead/tasks/{task} playground.lead.api.tasks.lock
     */
    public function lock(
        Task $task,
        LockRequest $request
    ): JsonResponse|TaskResource {
        $validated = $request->validated();

        $task->setAttribute('locked', true);

        $task->save();

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Task resources.
     *
     * @route GET /api/lead/tasks playground.lead.api.tasks
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TaskCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Task::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new TaskCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Task resource from the trash.
     *
     * @route PUT /api/lead/tasks/restore/{task} playground.lead.api.tasks.restore
     */
    public function restore(
        Task $task,
        RestoreRequest $request
    ): JsonResponse|TaskResource {
        $validated = $request->validated();

        $user = $request->user();

        $task->restore();

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Task resource.
     *
     * @route GET /api/lead/tasks/{task} playground.lead.api.tasks.show
     */
    public function show(
        Task $task,
        ShowRequest $request
    ): JsonResponse|TaskResource {
        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Task resource in storage.
     *
     * @route POST /api/lead/tasks playground.lead.api.tasks.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TaskResource {
        $validated = $request->validated();

        $user = $request->user();

        $task = new Task($validated);

        $task->created_by_id = $user?->id;

        $task->save();

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Task resource in storage.
     *
     * @route DELETE /api/lead/tasks/lock/{task} playground.lead.api.tasks.unlock
     */
    public function unlock(
        Task $task,
        UnlockRequest $request
    ): JsonResponse|TaskResource {
        $validated = $request->validated();

        $task->setAttribute('locked', false);

        $task->save();

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Task resource in storage.
     *
     * @route PATCH /api/lead/tasks/{task} playground.lead.api.tasks.patch
     */
    public function update(
        Task $task,
        UpdateRequest $request
    ): JsonResponse|TaskResource {
        $validated = $request->validated();

        $user = $request->user();

        $task->modified_by_id = $user?->id;

        $task->update($validated);

        return (new TaskResource($task))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}

<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Lead\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Lead\Models\Task;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\TaskTestCase
 */
class TaskTestCase extends PlaygroundCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Task::class;

    protected int $status_code_json_guest_create = 401;

    protected int $status_code_json_guest_destroy = 401;

    protected int $status_code_json_guest_edit = 401;

    protected int $status_code_json_guest_index = 401;

    protected int $status_code_json_guest_lock = 401;

    protected int $status_code_json_guest_restore = 401;

    protected int $status_code_json_guest_show = 401;

    protected int $status_code_guest_json_store = 401;

    protected int $status_code_guest_json_unlock = 401;

    protected int $status_code_guest_json_update = 401;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_camel' => 'task',
        'model_camels' => 'tasks',
        'model_kebab' => 'task',
        'model_kebabs' => 'tasks',
        'model_lower' => 'task',
        'model_lowers' => 'tasks',
        'model_label' => 'Task',
        'model_label_plural' => 'Tasks',
        'model_labels' => 'Tasks',
        'model_route' => 'playground.lead.api.tasks',
        'model_route_param' => 'task',
        'model_slug' => 'task',
        'model_slugs' => 'tasks',
        'model_slug_plural' => 'tasks',
        'model_snake' => 'task',
        'model_snakes' => 'tasks',
        'model_studly' => 'Task',
        'model_studlies' => 'Tasks',
        'model_variable' => 'task',
        'model_variables' => 'tasks',
        'model_variable_plural' => 'tasks',
        'module_label' => 'Lead',
        'module_label_plural' => 'Leads',
        'module_labels' => 'Leads',
        'module_route' => 'playground.lead.api',
        'module_slug' => 'lead',
        'module_slugs' => 'leads',
        'privilege' => 'playground-lead-api:task',
        'table' => 'lead_tasks',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'task_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'campaign_id',
        'goal_id',
        'lead_id',
        'opportunity_id',
        'plan_id',
        'region_id',
        'report_id',
        'source_id',
        'team_id',
        'teammate_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'planned_end_at',
        'planned_start_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resolved_at',
        'resumed_at',
        'suspended_at',
        'timer_end_at',
        'timer_start_at',
        'gids',
        'po',
        'pg',
        'pw',
        'only_admin',
        'only_user',
        'only_guest',
        'allow_public',
        'status',
        'rank',
        'size',
        'matrix',
        'x',
        'y',
        'z',
        'r',
        'theta',
        'rho',
        'phi',
        'elevation',
        'latitude',
        'longitude',
        'active',
        'canceled',
        'closed',
        'completed',
        'cron',
        'duplicate',
        'featured',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'prioritized',
        'problem',
        'published',
        'released',
        'resolved',
        'retired',
        'sms',
        'special',
        'suspended',
        'unknown',
        'locale',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'email',
        'phone',
        'team_role',
        'currency',
        'amount',
        'bonus',
        'bonus_rate',
        'commission',
        'commission_rate',
        'estimate',
        'fees',
        'materials',
        'services',
        'shipping',
        'subtotal',
        'taxable',
        'tax_rate',
        'taxes',
        'total',
        'icon',
        'image',
        'avatar',
        'ui',
        'address',
        'assets',
        'contact',
        'meta',
        'notes',
        'options',
        'sources',
    ];
}

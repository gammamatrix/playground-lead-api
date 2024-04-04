<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\GoalTestCase
 */
class GoalTestCase extends TestCase
{
    public string $fqdn = \Playground\Lead\Models\Goal::class;

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
}

<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Lead\Api\Http\Requests\Campaign;

use Playground\Http\Requests\IndexRequest as BaseIndexRequest;

/**
 * \Playground\Lead\Api\Http\Requests\Campaign\IndexRequest
 */
class IndexRequest extends BaseIndexRequest
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationDates = [
        'created_at' => ['column' => 'created_at', 'label' => 'Created at', 'nullable' => true],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated at', 'nullable' => true],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted at', 'nullable' => true],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled at', 'nullable' => true],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed at', 'nullable' => true],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo at', 'nullable' => true],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed at', 'nullable' => true],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned end at', 'nullable' => true],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned start at', 'nullable' => true],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed at', 'nullable' => true],
        'published_at' => ['column' => 'published_at', 'label' => 'Published at', 'nullable' => true],
        'released_at' => ['column' => 'released_at', 'label' => 'Released at', 'nullable' => true],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed at', 'nullable' => true],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved at', 'nullable' => true],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended at', 'nullable' => true],
        'timer_end_at' => ['column' => 'timer_end_at', 'label' => 'Timer end at', 'nullable' => true],
        'timer_start_at' => ['column' => 'timer_start_at', 'label' => 'Timer start at', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationFlags = [
        'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
        'cron' => ['column' => 'cron', 'label' => 'Cron', 'icon' => 'fa-regular fa-clock'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'fa-solid fa-clone'],
        'featured' => ['column' => 'featured', 'label' => 'Featured', 'icon' => 'fa-solid fa-star text-warning'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'icon' => 'fa-solid fa-wrench'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
        'prioritized' => ['column' => 'prioritized', 'label' => 'Prioritized', 'icon' => 'fa-solid fa-triangle-exclamation text-success'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
        'published' => ['column' => 'published', 'label' => 'Published', 'icon' => 'fa-solid fa-book'],
        'released' => ['column' => 'released', 'label' => 'Released', 'icon' => 'fa-solid fa-dove'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'icon' => 'fa-solid fa-check-double text-success'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
        'sms' => ['column' => 'sms', 'label' => 'Sms', 'icon' => 'fa-solid fa-comment-sms'],
        'special' => ['column' => 'special', 'label' => 'Special', 'icon' => 'fa-solid fa-star text-success'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationIds = [
        'id' => ['column' => 'id', 'label' => 'ID', 'type' => 'string', 'nullable' => true],
        'campaign_type' => ['column' => 'campaign_type', 'label' => 'Campaign Type', 'type' => 'string', 'nullable' => true],
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created by id', 'type' => 'uuid', 'nullable' => true],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified by id', 'type' => 'uuid', 'nullable' => true],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned by id', 'type' => 'uuid', 'nullable' => true],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent id', 'type' => 'uuid', 'nullable' => true],
        'goal_id' => ['column' => 'goal_id', 'label' => 'Goal id', 'type' => 'uuid', 'nullable' => true],
        'lead_id' => ['column' => 'lead_id', 'label' => 'Lead id', 'type' => 'uuid', 'nullable' => true],
        'opportunity_id' => ['column' => 'opportunity_id', 'label' => 'Opportunity id', 'type' => 'uuid', 'nullable' => true],
        'plan_id' => ['column' => 'plan_id', 'label' => 'Plan id', 'type' => 'uuid', 'nullable' => true],
        'region_id' => ['column' => 'region_id', 'label' => 'Region id', 'type' => 'uuid', 'nullable' => true],
        'report_id' => ['column' => 'report_id', 'label' => 'Report id', 'type' => 'uuid', 'nullable' => true],
        'source_id' => ['column' => 'source_id', 'label' => 'Source id', 'type' => 'uuid', 'nullable' => true],
        'task_id' => ['column' => 'task_id', 'label' => 'Task id', 'type' => 'uuid', 'nullable' => true],
        'team_id' => ['column' => 'team_id', 'label' => 'Team id', 'type' => 'uuid', 'nullable' => true],
        'teammate_id' => ['column' => 'teammate_id', 'label' => 'Teammate id', 'type' => 'uuid', 'nullable' => true],
        'matrix_id' => ['column' => 'matrix_id', 'label' => 'Matrix id', 'type' => 'uuid', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $paginationColumns = [
        'locale' => ['column' => 'locale', 'label' => 'Locale', 'type' => 'string', 'nullable' => true],
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string', 'nullable' => true],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string', 'nullable' => true],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string', 'nullable' => true],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string', 'nullable' => true],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string', 'nullable' => true],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string', 'nullable' => true],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string', 'nullable' => true],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'mediumText', 'nullable' => true],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'mediumText', 'nullable' => true],
        'email' => ['column' => 'email', 'label' => 'Email', 'type' => 'string', 'nullable' => true],
        'phone' => ['column' => 'phone', 'label' => 'Phone', 'type' => 'string', 'nullable' => true],
        'team_role' => ['column' => 'team_role', 'label' => 'Team role', 'type' => 'string', 'nullable' => true],
        'currency' => ['column' => 'currency', 'label' => 'Currency', 'type' => 'string', 'nullable' => true],
        'amount' => ['column' => 'amount', 'label' => 'Amount', 'type' => 'decimal', 'nullable' => true],
        'bonus' => ['column' => 'bonus', 'label' => 'Bonus', 'type' => 'decimal', 'nullable' => true],
        'bonus_rate' => ['column' => 'bonus_rate', 'label' => 'Bonus rate', 'type' => 'decimal', 'nullable' => true],
        'commission' => ['column' => 'commission', 'label' => 'Commission', 'type' => 'decimal', 'nullable' => true],
        'commission_rate' => ['column' => 'commission_rate', 'label' => 'Commission rate', 'type' => 'decimal', 'nullable' => true],
        'estimate' => ['column' => 'estimate', 'label' => 'Estimate', 'type' => 'decimal', 'nullable' => true],
        'fees' => ['column' => 'fees', 'label' => 'Fees', 'type' => 'decimal', 'nullable' => true],
        'materials' => ['column' => 'materials', 'label' => 'Materials', 'type' => 'decimal', 'nullable' => true],
        'services' => ['column' => 'services', 'label' => 'Services', 'type' => 'decimal', 'nullable' => true],
        'shipping' => ['column' => 'shipping', 'label' => 'Shipping', 'type' => 'decimal', 'nullable' => true],
        'subtotal' => ['column' => 'subtotal', 'label' => 'Subtotal', 'type' => 'decimal', 'nullable' => true],
        'taxable' => ['column' => 'taxable', 'label' => 'Taxable', 'type' => 'decimal', 'nullable' => true],
        'tax_rate' => ['column' => 'tax_rate', 'label' => 'Tax rate', 'type' => 'decimal', 'nullable' => true],
        'taxes' => ['column' => 'taxes', 'label' => 'Taxes', 'type' => 'decimal', 'nullable' => true],
        'total' => ['column' => 'total', 'label' => 'Total', 'type' => 'decimal', 'nullable' => true],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $sortable = [
        'id' => ['column' => 'id', 'label' => 'ID', 'type' => 'string'],
        'campaign_type' => ['column' => 'campaign_type', 'label' => 'Campaign Type', 'type' => 'string'],
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created by id', 'type' => 'string'],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified by id', 'type' => 'string'],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned by id', 'type' => 'string'],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent id', 'type' => 'string'],
        'goal_id' => ['column' => 'goal_id', 'label' => 'Goal id', 'type' => 'string'],
        'lead_id' => ['column' => 'lead_id', 'label' => 'Lead id', 'type' => 'string'],
        'opportunity_id' => ['column' => 'opportunity_id', 'label' => 'Opportunity id', 'type' => 'string'],
        'plan_id' => ['column' => 'plan_id', 'label' => 'Plan id', 'type' => 'string'],
        'region_id' => ['column' => 'region_id', 'label' => 'Region id', 'type' => 'string'],
        'report_id' => ['column' => 'report_id', 'label' => 'Report id', 'type' => 'string'],
        'source_id' => ['column' => 'source_id', 'label' => 'Source id', 'type' => 'string'],
        'task_id' => ['column' => 'task_id', 'label' => 'Task id', 'type' => 'string'],
        'team_id' => ['column' => 'team_id', 'label' => 'Team id', 'type' => 'string'],
        'teammate_id' => ['column' => 'teammate_id', 'label' => 'Teammate id', 'type' => 'string'],
        'matrix_id' => ['column' => 'matrix_id', 'label' => 'Matrix id', 'type' => 'string'],
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'type' => 'string'],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'type' => 'string'],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'type' => 'string'],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled at', 'type' => 'string'],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed at', 'type' => 'string'],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo at', 'type' => 'string'],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed at', 'type' => 'string'],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned end at', 'type' => 'string'],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned start at', 'type' => 'string'],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed at', 'type' => 'string'],
        'published_at' => ['column' => 'published_at', 'label' => 'Published at', 'type' => 'string'],
        'released_at' => ['column' => 'released_at', 'label' => 'Released at', 'type' => 'string'],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed at', 'type' => 'string'],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved at', 'type' => 'string'],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended at', 'type' => 'string'],
        'timer_end_at' => ['column' => 'timer_end_at', 'label' => 'Timer end at', 'type' => 'string'],
        'timer_start_at' => ['column' => 'timer_start_at', 'label' => 'Timer start at', 'type' => 'string'],
        'gids' => ['column' => 'gids', 'label' => 'Gids', 'type' => 'integer'],
        'po' => ['column' => 'po', 'label' => 'Po', 'type' => 'integer'],
        'pg' => ['column' => 'pg', 'label' => 'Pg', 'type' => 'integer'],
        'pw' => ['column' => 'pw', 'label' => 'Pw', 'type' => 'integer'],
        'only_admin' => ['column' => 'only_admin', 'label' => 'Only admin', 'type' => 'boolean'],
        'only_user' => ['column' => 'only_user', 'label' => 'Only user', 'type' => 'boolean'],
        'only_guest' => ['column' => 'only_guest', 'label' => 'Only guest', 'type' => 'boolean'],
        'allow_public' => ['column' => 'allow_public', 'label' => 'Allow public', 'type' => 'boolean'],
        'status' => ['column' => 'status', 'label' => 'Status', 'type' => 'integer'],
        'rank' => ['column' => 'rank', 'label' => 'Rank', 'type' => 'integer'],
        'size' => ['column' => 'size', 'label' => 'Size', 'type' => 'integer'],
        'matrix' => ['column' => 'matrix', 'label' => 'Matrix', 'type' => 'JSON_OBJECT'],
        'x' => ['column' => 'x', 'label' => 'X', 'type' => 'integer'],
        'y' => ['column' => 'y', 'label' => 'Y', 'type' => 'integer'],
        'z' => ['column' => 'z', 'label' => 'Z', 'type' => 'integer'],
        'r' => ['column' => 'r', 'label' => 'R', 'type' => 'float'],
        'theta' => ['column' => 'theta', 'label' => 'Theta', 'type' => 'float'],
        'rho' => ['column' => 'rho', 'label' => 'Rho', 'type' => 'float'],
        'phi' => ['column' => 'phi', 'label' => 'Phi', 'type' => 'float'],
        'elevation' => ['column' => 'elevation', 'label' => 'Elevation', 'type' => 'float'],
        'latitude' => ['column' => 'latitude', 'label' => 'Latitude', 'type' => 'float'],
        'longitude' => ['column' => 'longitude', 'label' => 'Longitude', 'type' => 'float'],
        'active' => ['column' => 'active', 'label' => 'Active', 'type' => 'boolean'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'type' => 'boolean'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'type' => 'boolean'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'type' => 'boolean'],
        'cron' => ['column' => 'cron', 'label' => 'Cron', 'type' => 'boolean'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'type' => 'boolean'],
        'featured' => ['column' => 'featured', 'label' => 'Featured', 'type' => 'boolean'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'type' => 'boolean'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'type' => 'boolean'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'type' => 'boolean'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'type' => 'boolean'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'type' => 'boolean'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'type' => 'boolean'],
        'prioritized' => ['column' => 'prioritized', 'label' => 'Prioritized', 'type' => 'boolean'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'type' => 'boolean'],
        'published' => ['column' => 'published', 'label' => 'Published', 'type' => 'boolean'],
        'released' => ['column' => 'released', 'label' => 'Released', 'type' => 'boolean'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'type' => 'boolean'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'type' => 'boolean'],
        'sms' => ['column' => 'sms', 'label' => 'Sms', 'type' => 'boolean'],
        'special' => ['column' => 'special', 'label' => 'Special', 'type' => 'boolean'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'type' => 'boolean'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'type' => 'boolean'],
        'locale' => ['column' => 'locale', 'label' => 'Locale', 'type' => 'string'],
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string'],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string'],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string'],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string'],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string'],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string'],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string'],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'string'],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'string'],
        'email' => ['column' => 'email', 'label' => 'Email', 'type' => 'string'],
        'phone' => ['column' => 'phone', 'label' => 'Phone', 'type' => 'string'],
        'team_role' => ['column' => 'team_role', 'label' => 'Team role', 'type' => 'string'],
        'currency' => ['column' => 'currency', 'label' => 'Currency', 'type' => 'string'],
        'amount' => ['column' => 'amount', 'label' => 'Amount', 'type' => 'float'],
        'bonus' => ['column' => 'bonus', 'label' => 'Bonus', 'type' => 'float'],
        'bonus_rate' => ['column' => 'bonus_rate', 'label' => 'Bonus rate', 'type' => 'float'],
        'commission' => ['column' => 'commission', 'label' => 'Commission', 'type' => 'float'],
        'commission_rate' => ['column' => 'commission_rate', 'label' => 'Commission rate', 'type' => 'float'],
        'estimate' => ['column' => 'estimate', 'label' => 'Estimate', 'type' => 'float'],
        'fees' => ['column' => 'fees', 'label' => 'Fees', 'type' => 'float'],
        'materials' => ['column' => 'materials', 'label' => 'Materials', 'type' => 'float'],
        'services' => ['column' => 'services', 'label' => 'Services', 'type' => 'float'],
        'shipping' => ['column' => 'shipping', 'label' => 'Shipping', 'type' => 'float'],
        'subtotal' => ['column' => 'subtotal', 'label' => 'Subtotal', 'type' => 'float'],
        'taxable' => ['column' => 'taxable', 'label' => 'Taxable', 'type' => 'float'],
        'tax_rate' => ['column' => 'tax_rate', 'label' => 'Tax rate', 'type' => 'float'],
        'taxes' => ['column' => 'taxes', 'label' => 'Taxes', 'type' => 'float'],
        'total' => ['column' => 'total', 'label' => 'Total', 'type' => 'float'],
        'icon' => ['column' => 'icon', 'label' => 'Icon', 'type' => 'string'],
        'image' => ['column' => 'image', 'label' => 'Image', 'type' => 'string'],
        'avatar' => ['column' => 'avatar', 'label' => 'Avatar', 'type' => 'string'],
        'ui' => ['column' => 'ui', 'label' => 'Ui', 'type' => 'JSON_OBJECT'],
        'address' => ['column' => 'address', 'label' => 'Address', 'type' => 'JSON_OBJECT'],
        'assets' => ['column' => 'assets', 'label' => 'Assets', 'type' => 'JSON_OBJECT'],
        'contact' => ['column' => 'contact', 'label' => 'Contact', 'type' => 'JSON_OBJECT'],
        'meta' => ['column' => 'meta', 'label' => 'Meta', 'type' => 'JSON_OBJECT'],
        'notes' => ['column' => 'notes', 'label' => 'Notes', 'type' => 'JSON_ARRAY'],
        'options' => ['column' => 'options', 'label' => 'Options', 'type' => 'JSON_OBJECT'],
        'sources' => ['column' => 'sources', 'label' => 'Sources', 'type' => 'JSON_OBJECT'],
    ];
}

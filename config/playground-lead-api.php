<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Lead\Api\Policies\CampaignPolicy;
use Playground\Lead\Api\Policies\GoalPolicy;
use Playground\Lead\Api\Policies\LeadPolicy;
use Playground\Lead\Api\Policies\OpportunityPolicy;
use Playground\Lead\Api\Policies\PlanPolicy;
use Playground\Lead\Api\Policies\RegionPolicy;
use Playground\Lead\Api\Policies\ReportPolicy;
use Playground\Lead\Api\Policies\SourcePolicy;
use Playground\Lead\Api\Policies\TaskPolicy;
use Playground\Lead\Api\Policies\TeammatePolicy;
use Playground\Lead\Api\Policies\TeamPolicy;
use Playground\Lead\Models\Campaign;
use Playground\Lead\Models\Goal;
use Playground\Lead\Models\Lead;
use Playground\Lead\Models\Opportunity;
use Playground\Lead\Models\Plan;
use Playground\Lead\Models\Region;
use Playground\Lead\Models\Report;
use Playground\Lead\Models\Source;
use Playground\Lead\Models\Task;
use Playground\Lead\Models\Team;
use Playground\Lead\Models\Teammate;

/**
 * Playground: Lead API Configuration and Environment Variables
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_LEAD_API_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_LEAD_API_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_LEAD_API_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_LEAD_API_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_LEAD_API_MIDDLEWARE_DEFAULT', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_LEAD_API_MIDDLEWARE_AUTH', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_LEAD_API_MIDDLEWARE_GUEST', [
            'web',
            SubstituteBindings::class,
            EnsureFrontendRequestsAreStateful::class,
        ]),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Campaign::class => CampaignPolicy::class,
        Goal::class => GoalPolicy::class,
        Lead::class => LeadPolicy::class,
        Opportunity::class => OpportunityPolicy::class,
        Plan::class => PlanPolicy::class,
        Region::class => RegionPolicy::class,
        Report::class => ReportPolicy::class,
        Source::class => SourcePolicy::class,
        Task::class => TaskPolicy::class,
        Team::class => TeamPolicy::class,
        Teammate::class => TeammatePolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'campaigns' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_CAMPAIGNS', true),
        'goals' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_GOALS', true),
        'leads' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_LEADS', true),
        'opportunities' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_OPPORTUNITIES', true),
        'plans' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_PLANS', true),
        'regions' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_REGIONS', true),
        'reports' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_REPORTS', true),
        'sources' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_SOURCES', true),
        'tasks' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_TASKS', true),
        'teams' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_TEAMS', true),
        'teammates' => (bool) env('PLAYGROUND_LEAD_API_ROUTES_TEAMMATES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-lead-api:*',
        ],
        'manager' => [
            'playground-lead-api:campaign:*',
            'playground-lead-api:goal:*',
            'playground-lead-api:lead:*',
            'playground-lead-api:opportunity:*',
            'playground-lead-api:plan:*',
            'playground-lead-api:region:*',
            'playground-lead-api:report:*',
            'playground-lead-api:source:*',
            'playground-lead-api:task:*',
            'playground-lead-api:team:*',
            'playground-lead-api:teammate:*',
        ],
        'user' => [
            'playground-lead-api:campaign:view',
            'playground-lead-api:campaign:viewAny',
            'playground-lead-api:goal:view',
            'playground-lead-api:goal:viewAny',
            'playground-lead-api:lead:view',
            'playground-lead-api:lead:viewAny',
            'playground-lead-api:opportunity:view',
            'playground-lead-api:opportunity:viewAny',
            'playground-lead-api:plan:view',
            'playground-lead-api:plan:viewAny',
            'playground-lead-api:region:view',
            'playground-lead-api:region:viewAny',
            'playground-lead-api:report:view',
            'playground-lead-api:report:viewAny',
            'playground-lead-api:source:view',
            'playground-lead-api:source:viewAny',
            'playground-lead-api:task:view',
            'playground-lead-api:task:viewAny',
            'playground-lead-api:team:view',
            'playground-lead-api:team:viewAny',
            'playground-lead-api:teammate:view',
            'playground-lead-api:teammate:viewAny',
        ],
    ],
];

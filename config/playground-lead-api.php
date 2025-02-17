<?php
/**
 * Playground
 */

declare(strict_types=1);

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
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_LEAD_API_MIDDLEWARE_AUTH', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_LEAD_API_MIDDLEWARE_GUEST', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
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
        Playground\Lead\Models\Campaign::class => Playground\Lead\Api\Policies\CampaignPolicy::class,
        Playground\Lead\Models\Goal::class => Playground\Lead\Api\Policies\GoalPolicy::class,
        Playground\Lead\Models\Lead::class => Playground\Lead\Api\Policies\LeadPolicy::class,
        Playground\Lead\Models\Opportunity::class => Playground\Lead\Api\Policies\OpportunityPolicy::class,
        Playground\Lead\Models\Plan::class => Playground\Lead\Api\Policies\PlanPolicy::class,
        Playground\Lead\Models\Region::class => Playground\Lead\Api\Policies\RegionPolicy::class,
        Playground\Lead\Models\Report::class => Playground\Lead\Api\Policies\ReportPolicy::class,
        Playground\Lead\Models\Source::class => Playground\Lead\Api\Policies\SourcePolicy::class,
        Playground\Lead\Models\Task::class => Playground\Lead\Api\Policies\TaskPolicy::class,
        Playground\Lead\Models\Team::class => Playground\Lead\Api\Policies\TeamPolicy::class,
        Playground\Lead\Models\Teammate::class => Playground\Lead\Api\Policies\TeammatePolicy::class,
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

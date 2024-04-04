<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Lead\Api\Http\Controllers\OpportunityTestCase;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground\OpportunityRouteTest
 */
class OpportunityRouteTest extends OpportunityTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_lead = true;
}

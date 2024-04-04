<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Lead\Api\Http\Controllers\LeadTestCase;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground\LeadRouteTest
 */
class LeadRouteTest extends LeadTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_lead = true;
}

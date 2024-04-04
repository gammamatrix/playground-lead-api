<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Lead\Api\Http\Controllers\RegionTestCase;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground\RegionRouteTest
 */
class RegionRouteTest extends RegionTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_lead = true;
}

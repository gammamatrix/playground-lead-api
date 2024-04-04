<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Lead\Api\Http\Controllers\TeamTestCase;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground\TeamRouteTest
 */
class TeamRouteTest extends TeamTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_lead = true;
}

<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Lead\Api\Http\Controllers\TaskTestCase;

/**
 * \Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground\TaskRouteTest
 */
class TaskRouteTest extends TaskTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_lead = true;
}

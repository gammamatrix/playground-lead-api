<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Lead\Api\TestTrait;

/**
 * \Tests\Feature\Playground\Lead\Api\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use TestTrait;

    protected bool $load_migrations_playground = false;

    protected bool $load_migrations_lead = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
            if ($this->load_migrations_lead) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-lead-uuid');
            }
        }
    }
}

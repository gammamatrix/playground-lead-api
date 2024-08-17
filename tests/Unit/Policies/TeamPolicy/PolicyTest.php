<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Lead\Api\Policies\TeamPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Lead\Api\Policies\TeamPolicy;
use Tests\Unit\Playground\Lead\Api\TestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Policies\TeamPolicy\PolicyTest
 */
#[CoversClass(TeamPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new TeamPolicy;

        $this->assertInstanceOf(TeamPolicy::class, $instance);
    }
}

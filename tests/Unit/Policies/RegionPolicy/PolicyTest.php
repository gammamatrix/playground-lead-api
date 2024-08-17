<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Lead\Api\Policies\RegionPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Lead\Api\Policies\RegionPolicy;
use Tests\Unit\Playground\Lead\Api\TestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Policies\RegionPolicy\PolicyTest
 */
#[CoversClass(RegionPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new RegionPolicy;

        $this->assertInstanceOf(RegionPolicy::class, $instance);
    }
}

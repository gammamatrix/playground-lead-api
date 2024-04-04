<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Lead\Api\Policies\CampaignPolicy;

// use Illuminate\Support\Facades\Artisan;
use Playground\Lead\Api\Policies\CampaignPolicy;
use Tests\Unit\Playground\Lead\Api\TestCase;

/**
 * \ests\Unit\Playground\Lead\Api\Policies\CampaignPolicy\PolicyTest
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new CampaignPolicy;

        $this->assertInstanceOf(CampaignPolicy::class, $instance);
    }
}

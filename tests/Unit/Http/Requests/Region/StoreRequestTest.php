<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Lead\Api\Http\Requests\Region;

use Playground\Lead\Api\Http\Requests\Region\StoreRequest;
use Tests\Unit\Playground\Lead\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Http\Requests\Region\StoreRequestTest
 */
class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;

    public function test_StoreRequest_rules_with_optional_revisions_disabled(): void
    {
        config(['playground-lead-api.revisions.optional' => false]);
        $instance = new StoreRequest;
        $rules = $instance->rules();
        $this->assertNotEmpty($rules);
        $this->assertIsArray($rules);
        $this->assertArrayNotHasKey('revision', $rules);
    }

    public function test_StoreRequest_rules_with_optional_revisions_enabled(): void
    {
        config(['playground-lead-api.revisions.optional' => true]);
        $instance = new StoreRequest;
        $rules = $instance->rules();
        $this->assertNotEmpty($rules);
        $this->assertIsArray($rules);
        $this->assertArrayHasKey('revision', $rules);
        $this->assertSame('bool', $rules['revision']);
    }
}

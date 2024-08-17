<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Lead\Api\Http\Requests\Team;

use Tests\Unit\Playground\Lead\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Http\Requests\Team\UnlockRequestTest
 */
class UnlockRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Lead\Api\Http\Requests\Team\UnlockRequest::class;
}

<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Lead\Api\Http\Requests\Campaign;

use Playground\Lead\Api\Http\Requests\Campaign\StoreRequest;
use Tests\Unit\Playground\Lead\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Http\Requests\Campaign\StoreRequestTest
 */
class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;
}

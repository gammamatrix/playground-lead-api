<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Lead\Api\Http\Requests\Campaign;

use Playground\Lead\Api\Http\Requests\Campaign\UpdateRequest;
use Tests\Unit\Playground\Lead\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Lead\Api\Http\Requests\Campaign\UpdateRequestTest
 */
class UpdateRequestTest extends RequestTestCase
{
    protected string $requestClass = UpdateRequest::class;
}

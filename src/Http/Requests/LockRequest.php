<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Requests;

/**
 * \Playground\Lead\Api\Http\Requests\LockRequest
 */
class LockRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}

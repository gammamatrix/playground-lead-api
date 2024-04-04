<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Http\Requests\Team;

use Playground\Lead\Api\Http\Requests\FormRequest;

/**
 * \Playground\Lead\Api\Http\Requests\Team\RestoreRequest
 */
class RestoreRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}

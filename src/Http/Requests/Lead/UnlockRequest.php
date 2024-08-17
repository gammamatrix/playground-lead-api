<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Lead\Api\Http\Requests\Lead;

use Playground\Lead\Api\Http\Requests\FormRequest;

/**
 * \Playground\Lead\Api\Http\Requests\Lead\UnlockRequest
 */
class UnlockRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}

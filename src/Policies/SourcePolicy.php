<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Lead\Api\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Lead\Api\Policies\SourcePolicy
 */
class SourcePolicy extends ModelPolicy
{
    protected string $package = 'playground-lead-api';

    /**
     * @var array<int, string> The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'sales',
        'manager',
        'admin',
        'root',
    ];

    /**
     * @var array<int, string> The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'sales',
        'manager',
        'admin',
        'root',
    ];
}

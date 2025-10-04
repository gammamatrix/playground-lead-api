<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Lead\Api\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Lead\Api\Policies\OpportunityPolicy
 */
class OpportunityPolicy extends ModelPolicy
{
    protected string $package = 'playground-lead-api';

    /**
     * @var array<int, string> The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'publisher',
        'manager',
        'admin',
        'root',
    ];

    /**
     * @var array<int, string> The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'publisher',
        'manager',
        'admin',
        'root',
    ];
}

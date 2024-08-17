<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Lead\Api\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Lead\Api\Policies\ReportPolicy
 */
class ReportPolicy extends ModelPolicy
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

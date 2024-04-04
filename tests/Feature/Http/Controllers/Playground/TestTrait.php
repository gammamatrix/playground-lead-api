<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Lead\Api\Http\Controllers\Playground;

/**
 * \Tests\Unit\Playground\Lead\Api\Playground\TestTrait
 */
trait TestTrait
{
    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('auth.providers.users.model', '\\Playground\\Models\\Playground');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-lead.load.migrations', true);

        $app['config']->set('app.debug', false);
        $app['config']->set('playground-auth.debug', false);

        $app['config']->set('playground-auth.verify', 'roles');
        // $app['config']->set('playground-auth.verify', 'privileges');
        $app['config']->set('playground-auth.sanctum', false);
        $app['config']->set('playground-auth.hasPrivilege', true);
        $app['config']->set('playground-auth.userPrivileges', true);
        $app['config']->set('playground-auth.hasRole', true);
        $app['config']->set('playground-auth.userRole', true);
        $app['config']->set('playground-auth.userRoles', true);

        // $app['config']->set('playground-lead-api.routes.backlogs', true);
    }
}

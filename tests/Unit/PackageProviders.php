<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Lead\Api;

use Laravel\Sanctum\SanctumServiceProvider;
use Playground\ServiceProvider;

/**
 * \Tests\Unit\Playground\Lead\Api\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\Test\ServiceProvider::class,
            ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Lead\ServiceProvider::class,
            \Playground\Lead\Api\ServiceProvider::class,
            SanctumServiceProvider::class,
        ];
    }
}

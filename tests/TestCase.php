<?php declare(strict_types=1);

namespace Tests;

use Dive\Skeleton\SkeletonServiceProvider;
use Orchestra\Testbench\TestCase as TestCaseBase;

abstract class TestCase extends TestCaseBase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app): array
    {
        return [SkeletonServiceProvider::class];
    }

    protected function setUpDatabase($app): void
    {
        $app['db']->connection()->getSchemaBuilder()->dropAllTables();

        /*
        $skeleton = require __DIR__ . '/../database/migrations/create_skeleton_table.php.stub';
        $skeleton->up();
        */
    }
}

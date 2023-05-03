<?php declare(strict_types=1);

namespace Dive\Skeleton;

use Dive\Skeleton\Commands\SkeletonCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

final class SkeletonServiceProvider extends ServiceProvider
{
    public const NAME = 'skeleton';

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerMigration();
            $this->registerPublishing();
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', self::NAME);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/skeleton.php', self::NAME);
    }

    private function registerCommands(): void
    {
        $this->commands([SkeletonCommand::class]);
    }

    private function registerMigration(): void
    {
        $migration = 'create_skeleton_tables.php';
        $doesntExist = Collection::make(glob($this->app->databasePath('migrations/*.php')))
            ->every(fn ($filename) => ! str_ends_with($filename, $migration));

        if ($doesntExist) {
            $timestamp = date('Y_m_d_His', time());
            $stub = __DIR__."/../database/migrations/{$migration}.stub";

            $this->publishes([
                $stub => $this->app->databasePath("migrations/{$timestamp}_{$migration}"),
            ], 'migrations');
        }
    }

    private function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/skeleton.php' => $this->app->configPath('skeleton.php'),
        ], 'skeleton-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => $this->app->basePath('resources/views/vendor/skeleton'),
        ], 'skeleton-views');
    }
}

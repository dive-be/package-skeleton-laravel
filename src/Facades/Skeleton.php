<?php declare(strict_types=1);

namespace Dive\Skeleton\Facades;

use Dive\Skeleton\SkeletonServiceProvider;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Dive\Skeleton\Skeleton
 */
final class Skeleton extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SkeletonServiceProvider::NAME;
    }
}

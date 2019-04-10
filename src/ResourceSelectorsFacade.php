<?php

namespace Mujiciok\ResourceSelectors;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mujiciok\ResourceSelectors\Skeleton\SkeletonClass
 */
class ResourceSelectorsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-resource-selectors';
    }
}

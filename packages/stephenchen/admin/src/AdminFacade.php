<?php

namespace Stephenchen\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stephenchen\Admin\Skeleton\SkeletonClass
 */
class AdminFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin';
    }
}

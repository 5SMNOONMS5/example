<?php

namespace Stephenchen\Banner;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stephenchen\Banner\Skeleton\SkeletonClass
 */
class BannerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'banner';
    }
}

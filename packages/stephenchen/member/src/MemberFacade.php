<?php

namespace Stephenchen\Member;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stephenchen\User\Skeleton\SkeletonClass
 */
class MemberFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'member';
    }
}

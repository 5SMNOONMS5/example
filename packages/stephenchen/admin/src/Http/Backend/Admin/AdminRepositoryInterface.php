<?php

namespace Stephenchen\Admin\Http\Backend\Admin;

use Prettus\Repository\Contracts\RepositoryInterface;

interface AdminRepositoryInterface extends RepositoryInterface
{
    /**
     * Load relationship role
     *
     * @return $this
     */
    public function loadRelationshipRole();
}

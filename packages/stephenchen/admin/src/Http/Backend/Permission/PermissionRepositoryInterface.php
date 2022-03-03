<?php

namespace Stephenchen\Admin\Http\Backend\Permission;

use Prettus\Repository\Contracts\RepositoryInterface;

interface PermissionRepositoryInterface extends RepositoryInterface
{
    /**
     * Load all resources with relations first
     *
     * @return $this
     */
    public function loadRelationships();

    /**
     * When language ID
     *
     * @return $this
     */
    public function whenLanguageID();
}

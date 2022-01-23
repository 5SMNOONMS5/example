<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Stephenchen\Core\Http\Backend\Admin\AdminModel;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * Load all resources with relations first
     *
     * @return $this
     */
    public function loadRelationships();

    /**
     * @param AdminModel $admin
     */
    public function getPermissionsViaAdmin(AdminModel $admin);
}

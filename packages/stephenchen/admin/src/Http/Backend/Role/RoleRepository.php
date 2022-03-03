<?php

namespace Stephenchen\Admin\Http\Backend\Role;

use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Stephenchen\Admin\Http\Backend\Admin\AdminModel;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoleModel::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @inheritDoc
     */
    public function loadRelationships()
    {
        return $this->model->with(['permissions']);
    }

    /**
     * @inheritDoc
     */
    public function getPermissionsViaAdmin(AdminModel $admin): Collection
    {
        return $admin->getPermissionsViaRoles();
    }
}

<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PermissionModel::class;
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
        return $this->model->with(['template', 'operator', 'emails', 'type']);
    }

    /**
     * @inheritDoc
     */
    public function whenLanguageID()
    {
        return $this->model->whenLanguageId();
    }
}

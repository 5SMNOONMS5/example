<?php

namespace Stephenchen\Admin\Http\Backend\Admin;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminModel::class;
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
    public function loadRelationshipRole()
    {
        return $this->model->with(['roles']);
    }
}

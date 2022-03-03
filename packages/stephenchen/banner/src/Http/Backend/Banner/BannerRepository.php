<?php

namespace Stephenchen\Banner\Http\Backend\Banner;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BannerModel::class;
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
}

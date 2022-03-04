<?php

namespace Stephenchen\Banner\Http\Backend\Banner;

use Exception;
use Stephenchen\Core\Http\Resources\IndexResource;
use Stephenchen\Core\Traits\HelperPaginateTrait;

class BannerService
{
    use HelperPaginateTrait;

    /**
     * @var BannerRepositoryInterface
     */
    private BannerRepositoryInterface $repository;

    /**
     * Create a new BannerService instance.
     *
     * @param BannerRepositoryInterface $repository
     */
    public function __construct(BannerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $page    = request()->has('page');
        $perPage = request()->has('per_page');

        $sources = $this->repository
            ->when($page & $perPage, function ($query) {
                return $query
                    ->skip($this->getSkip())
                    ->take($this->getPerPage());
            })
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($element) {
                $prefix            = env('APP_URL');
                $path              = $element[ 'path' ];
                $element[ 'path' ] = "{$prefix}/storage{$path}";
                return $element;
            })
            ->toArray();

        $total = $this->repository->count();

        return ( new IndexResource() )
            ->to($sources, $total);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array|null
     */
    public function show(int $id): ?array
    {
        return $this->repository
//            ->loadRelationships()
            ->find($id)
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $parameters
     * @return bool
     * @throws Exception
     */
    public function store(array $parameters): bool
    {
        $this->repository->create($parameters);
        return TRUE;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $parameters
     * @param int $id
     * @return bool
     */
    public function update(array $parameters, int $id): ?bool
    {
        $entity = $this->repository->find($id);
        return $entity->update($parameters);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}



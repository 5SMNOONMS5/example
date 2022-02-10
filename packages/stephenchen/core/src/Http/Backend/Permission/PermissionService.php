<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Stephenchen\Core\Http\Resources\IndexResource;

class PermissionService
{
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $repository;

    /**
     * Create a new service instance.
     *
     * @param PermissionRepositoryInterface $repository
     */
    public function __construct(PermissionRepositoryInterface $repository)
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
        $sources = $this
            ->repository
            ->paginate()
            ->toArray();

        $permissions = $sources[ 'data' ];
        $total       = $sources[ 'total' ];

        return ( new IndexResource() )
            ->to($permissions, $total);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array|null
     */
    public function show(int $id): ?array
    {
        return $this->repository->find($id)->toArray() ?? NULL;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $parameters
     * @return mixed
     */
    public function store(array $parameters)
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
        return $this->repository
            ->find($id)
            ->update($parameters);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool|null
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository
            ->delete($id);
    }
}

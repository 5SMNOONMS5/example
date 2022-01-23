<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Exception;
use Illuminate\Support\Collection;
use Stephenchen\Core\Http\Backend\Admin\AdminModel;
use Stephenchen\Core\Http\Backend\Permission\PermissionRepositoryInterface;

class RoleService
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $repository;

    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * Create a new PermissionService instance.
     *
     * @param RoleRepositoryInterface $repository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(RoleRepositoryInterface $repository,
                                PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->repository           = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        return $this->repository->all()->toArray();
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
            ->loadRelationships()
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
        // @FIXME: 怪怪的 還有要修改 vue
        $permissionsIDs = $parameters[ 'permissionsIDs' ] ?? [];
        unset($parameters[ 'permissionsIDs' ]);

        $entity = $this->repository->create($parameters);

        $permissions = $this->permissionRepository->findWhereIn('id', $permissionsIDs);
        $entity->syncPermissions($permissions);

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
        $entity->update($parameters);

        $permissionIDs = $parameters[ 'permissionsIDs' ];
        $this->repository->sync($id, 'permissions', $permissionIDs);

        return TRUE;
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



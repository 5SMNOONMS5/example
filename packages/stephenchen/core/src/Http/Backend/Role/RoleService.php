<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Exception;
use Stephenchen\Core\Http\Backend\Permission\PermissionRepositoryInterface;
use Stephenchen\Core\Http\Resources\IndexResource;

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
        $sources = $this
            ->repository
            ->paginate()
            ->toArray();

        $roles = $sources[ 'data' ];
        $total = $sources[ 'total' ];

        return ( new IndexResource() )
            ->to($roles, $total);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array|null
     */
    public function show(int $id): ?array
    {
        $roles = $this->repository
            ->loadRelationships()
            ->find($id)
            ->toArray();

        $roles[ 'permissionIDs' ] = collect($roles[ 'permissions' ])
            ->pluck('id')
            ->toArray();

        unset($roles[ 'permissions' ]);
        return $roles;
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
        $permissionsIDs = $parameters[ 'permissionIDs' ] ?? [];
        unset($parameters[ 'permissionIDs' ]);

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

        $permissionIDs = $parameters[ 'permissionIDs' ];

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



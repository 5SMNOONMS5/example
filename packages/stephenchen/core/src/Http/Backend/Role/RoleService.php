<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Exception;
use Stephenchen\Core\Http\Backend\Permission\PermissionRepositoryInterface;
use Stephenchen\Core\Http\Resources\IndexResource;
use Stephenchen\Core\Traits\HelperPaginateTrait;

class RoleService
{
    use HelperPaginateTrait;

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
        $roles = $this->repository
            ->loadRelationships()
            ->find($id)
            ->toArray();

        $roles[ 'permission_ids' ] = collect($roles[ 'permissions' ])
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
        $permissionsIDs = $parameters[ 'permission_ids' ] ?? [];
        unset($parameters[ 'permission_ids' ]);

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

        $permissionIDs = $parameters[ 'permission_ids' ];

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



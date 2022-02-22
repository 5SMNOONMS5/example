<?php

namespace Stephenchen\Core\Http\Backend\Admin;

use Carbon\Carbon;
use Exception;
use Stephenchen\Core\Http\Backend\Auth\AuthService;
use Stephenchen\Core\Http\Backend\Role\RoleRepositoryInterface;
use Stephenchen\Core\Http\Resources\IndexResource;
use Stephenchen\Core\Traits\HelperPaginateTrait;
use Stephenchen\Core\Traits\HelperTrait;
use Stephenchen\Core\Utilities\ToTree;

final class AdminService
{
    use HelperTrait,
        HelperPaginateTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const GUARD_ADMIN = 'admins';

    /**
     * @var RoleRepositoryInterface
     */
    protected RoleRepositoryInterface $roleRepository;

    /**
     * @var AdminRepositoryInterface
     */
    private AdminRepositoryInterface $adminRepository;

    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * Create a new Service instance.
     *
     * @param RoleRepositoryInterface $roleRepository
     * @param AdminRepositoryInterface $adminRepository
     * @param AuthService $authService
     */
    public function __construct(RoleRepositoryInterface $roleRepository,
                                AdminRepositoryInterface $adminRepository,
                                AuthService $authService)
    {
        $this->roleRepository  = $roleRepository;
        $this->adminRepository = $adminRepository;
        $this->authService     = $authService;
    }

    /**
     * Update latest login infos such as `latest_ip` & `latest_login_at`
     *
     * @param $admin
     */
    public function updateLoginStatus($admin)
    {
        $admin->update([
            // Beware!!! , If you are using Cloudflare, plz see this first
            // https://khalilst.medium.com/get-real-client-ip-behind-cloudflare-in-laravel-189cb89059ff
            'latest_ip'       => request()->ip(),
            'latest_login_at' => Carbon::now(),
        ]);
    }

    /**
     * Get auth admin info and permissions
     *
     * @param $admin
     * @return array
     */
    public function me($admin)
    {
        $permissions = $this->roleRepository
            ->getPermissionsViaAdmin($admin)
            ->map(function ($permission) {
                $newPermission[ 'id' ]        = $permission[ 'id' ];
                $newPermission[ 'parent_id' ] = $permission[ 'parent_id' ];
                $newPermission[ 'name' ]      = $permission[ 'name' ];
                $newPermission[ 'path' ]      = $permission[ 'path' ];
                $newPermission[ 'icon' ]      = $permission[ 'icon' ];
                return $newPermission;
            })
            ->toArray();

        $permissions = ( new ToTree() )
            ->convert($permissions, 'parent_id');

        unset($admin[ 'roles' ]);

        return [
            'admin_infos' => $admin,
            'permissions' => $permissions,
        ];
    }

    /**
     * Register a new admin user
     *
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function store(array $parameters): bool
    {
        $additions  = [
            'latest_ip'       => request()->ip(),
            'latest_login_at' => Carbon::now(),
        ];
        $parameters = array_merge($parameters, $additions);
        $entity     = $this->adminRepository->create($parameters);

        // Update role
        $roleID = $parameters[ 'role_id' ];

        $role = $this->roleRepository->find($roleID);
        $entity->assignRole($role);

        return TRUE;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function destroy(int $id): ?bool
    {
        $admin = $this->authService->getAuthUser();

        if (( $admin->id ?? NULL ) == $id) {
            throw new Exception('不能刪除自己');
        }

        // @TIP: Admin had soft_delete so roles will not being detach
        $entity = $this->adminRepository->find($id);

        return $entity->delete();
    }

    /**
     * @inheritDoc
     */
    public function show(int $id): ?array
    {
        $admin              = $this->adminRepository
            ->loadRelationshipRole()
            ->find($id)
            ->toArray();
        $admin[ 'role_id' ] = $admin[ 'roles' ][ 0 ][ 'id' ] ?? NULL;
        unset($admin[ 'roles' ]);

        return $admin;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $parameters
     * @param int $id
     * @return array|null
     */
    public function update(array $parameters, int $id): ?bool
    {
        $entity = $this->adminRepository->find($id);

//        dd($parameters);

        if ($this->isArrayHasKey($parameters, 'password')) {
            $entity[ 'password' ] = $parameters[ 'password' ];
        }

        $roleID = $parameters[ 'role_id' ];
        $this->adminRepository->sync($id, 'roles', $roleID);

        $entity->update($parameters);

        return TRUE;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $authAdmin = $this->authService->getAuthUser();

        // Filter first, exclude self
        $source = $this->adminRepository
            ->scopeQuery(fn($query) => $query->where('id', '!=', $authAdmin->id))
            ->with('roles')
            ->orderBy('id', 'desc')
            ->paginate($this->getPerPage());

        $admins = collect($source->items())
            ->map(function ($admin) {
                $roles                = collect($admin[ 'roles' ]);
                $roleNames            = $roles->implode('name', ',');
                $admin[ 'role_name' ] = $roleNames;
                unset($admin[ 'roles' ]);
                return $admin;
            })
            ->values()
            ->toArray();

        $total = $source->total();

        return ( new IndexResource() )
            ->to($admins, $total);
    }
}

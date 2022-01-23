<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stephenchen\Core\Base\BaseController;

/**
 * Class RoleController
 *
 * @package App\Http\Backend\Role
 */
final class RoleController extends BaseController
{
    /**
     * @var RoleService
     */
    private RoleService $service;

    /**
     * Create a new Controller.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }

    /**
     * 把 Role 資料列出來
     * @OA\Get(
     *     path="/api/core/admins/roles",
     *     tags={"Role"},
     *     @OA\Response(response="200", description="成功")
     * )
     */
    public function index()
    {
        $results = $this->service->index();

        return $this->jsonSuccess('success', $results);
    }

    /**
     * 新增 Role, permission 也一並傳近來新增
     * @OA\Post(
     *     path="/api/core/admins/roles",
     *     tags={"Role"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      description="Updated name of the pet",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="permissionsIDs",
     *                      description="Updated status of the pet",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          description="permissions 的 id",
     *                      )
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @param  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 查看一筆 Role, 會把 permissions 一起回傳
     * @OA\Get(
     *     path="/api/core/admins/roles/{id}",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="role 的 id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $results = $this->service->show($id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 修改一筆 Role, permission 也一並傳近來一起修改
     * @OA\Put(
     *     path="/api/core/admins/roles/{id}",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="role 的 id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      description="Updated name of the pet",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="permissionsIDs",
     *                      description="Updated status of the pet",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          description="permissions 的 id",
     *                      )
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 刪除一筆 Role
     * @OA\Delete(
     *     path="/api/core/admins/roles/{id}",
     *     tags={"Role"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="role 的 id",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="成功"),
     * )
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $results = $this->service->destroy($id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }
}

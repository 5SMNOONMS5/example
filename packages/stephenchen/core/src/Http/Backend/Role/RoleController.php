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
     *     path="/admins/roles",
     *     tags={"Role"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
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
     *     path="/admins/roles",
     *     tags={"Role"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *         @OA\Header(
     *             header="X-Rate-Limit",
     *             @OA\Schema(
     *                 type="integer",
     *                 format="int32"
     *             ),
     *             description="calls per hour allowed by the user"
     *         ),
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
     *                      property="description",
     *                      description="描述",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="is_enabled",
     *                      description="狀態",
     *                      type="boolean"
     *                  ),
     *                  @OA\Property(
     *                      property="permissionIDs",
     *                      description="permissions 的 ID",
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
    public function store(RoleRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 查看一筆 Role, 會把 permissions 一起回傳
     * @OA\Get(
     *     path="/admins/roles/{id}",
     *     tags={"Role"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
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
     *     path="/admins/roles/{id}",
     *     tags={"Role"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
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
     *                      property="description",
     *                      description="描述",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="is_enabled",
     *                      description="狀態",
     *                      type="boolean"
     *                  ),
     *                  @OA\Property(
     *                      property="permissionIDs",
     *                      description="permissions 的 ID",
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
     * @param RoleRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 刪除一筆 Role
     * @OA\Delete(
     *     path="/admins/roles/{id}",
     *     tags={"Role"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
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

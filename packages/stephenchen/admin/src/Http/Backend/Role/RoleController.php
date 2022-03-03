<?php

namespace Stephenchen\Admin\Http\Backend\Role;

use Exception;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

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
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ( 沒有帶參數就全部吐回來 )",
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="per_page ( 沒有帶參數就全部吐回來 )",
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     */
    public function index()
    {
        $results = $this->service->index();

        return $this->jsonSuccess(trans('core::global.success'), $results);
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
     *                      property="status",
     *                      description="狀態",
     *                      type="boolean"
     *                  ),
     *                  @OA\Property(
     *                      property="permission_ids",
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
     * @return Response
     * @throws Exception
     */
    public function store(RoleRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
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
     * @return Response
     */
    public function show($id)
    {
        $results = $this->service->show($id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
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
     *                      property="status",
     *                      description="狀態",
     *                      type="boolean"
     *                  ),
     *                  @OA\Property(
     *                      property="permission_ids",
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
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
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
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $results = $this->service->destroy($id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
    }
}

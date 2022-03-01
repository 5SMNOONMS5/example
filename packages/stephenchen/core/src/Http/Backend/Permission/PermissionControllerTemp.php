<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

class PermissionControllerTemp extends BaseController
{
    /**
     * @PermissionService
     */
    private PermissionService $service;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $service
     */
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * 把 Permission 資料列出來
     * @OA\Get(
     *     path="/admins/permissions",
     *     tags={"Permission"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response="200", description="成功")
     * )
     */
    public function index()
    {
        $results = $this->service->index();

        return $this->jsonSuccess(trans('core::global.success'),  $results);
    }

    /**
     * 新增 Permission
     * @OA\Post(
     *     path="/admins/permissions",
     *     tags={"Permission"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="要新增的 permission name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(response="200", description="成功"),
     *     @OA\Response(response="422", description="參數不對，失敗")
     * )
     *
     * @param  $request
     * @return Response
     */
    public function store(PermissionRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 查看一筆 Permission
     * @OA\Get(
     *     path="/admins/permissions/{id}",
     *     tags={"Permission"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="permission 的 id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
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
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 修改一筆 Permission
     * @OA\Put(
     *     path="/admins/permissions/{id}",
     *     tags={"Permission"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="permission 的 id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="要修改的 name",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="成功"),
     *     @OA\Response(response="422", description="參數不對，失敗")
     * )
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param $id
     * @return Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 刪除一筆 Permission
     * @OA\Delete(
     *     path="/admins/permissions/{id}",
     *     tags={"Permission"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="permission 的 id",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="成功"),
     *     @OA\Response(response="400", description="當 template 已經有這語系的時候無法刪除")
     * )
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $results = $this->service->destroy($id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }
}

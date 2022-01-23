<?php

namespace Stephenchen\Core\Http\Backend\Permission;

use Illuminate\Http\JsonResponse;
use Stephenchen\Core\Base\BaseController;

class PermissionController extends BaseController
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
     *     path="/api/core/admins/permissions",
     *     tags={"Permission"},
     *     @OA\Response(response="200", description="成功")
     * )
     */
    public function index()
    {
        $results = $this->service->index();

        return $this->jsonSuccess('success', $results);
    }

    /**
     * 新增 Permission
     * @OA\Post(
     *     path="/api/core/admins/permissions",
     *     tags={"Permission"},
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
     * @return JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 查看一筆 Permission
     * @OA\Get(
     *     path="/api/core/admins/permissions/{id}",
     *     tags={"Permission"},
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
     * 修改一筆 Permission
     * @OA\Put(
     *     path="/api/core/admins/permissions/{id}",
     *     tags={"Permission"},
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
     * @return JsonResponse
     */
    public function update(PermissionRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 刪除一筆 Permission
     * @OA\Delete(
     *     path="/api/core/admins/permissions/{id}",
     *     tags={"Permission"},
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $results = $this->service->destroy($id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }
}

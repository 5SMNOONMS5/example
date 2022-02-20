<?php

namespace Stephenchen\Core\Http\Backend\Admin;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stephenchen\Core\Base\BaseController;

final class AdminController extends BaseController
{
    /**
     * @var AdminService
     */
    private AdminService $service;

    /**
     * Create a new AdminController instance.
     *
     * @param AdminService $service
     */
    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * 把 Admins 資料列出來, 但是不會顯示當前的自己
     * @OA\Get(
     *     path="/admins/authUser",
     *     tags={"Admin"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="admin 的 page ( 最小是 1 )",
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="admin 的 per_page ( 默認 20 )",
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

        return $this->jsonSuccess('success', $results);
    }

    /**
     * 新增 Admin
     * @OA\Post(
     *     path="/admins/authUser",
     *     tags={"Admin"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminModel")
     *          )
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @param  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(AdminRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 查看一筆 Admin, 會把 role 一併回傳
     * @OA\Get(
     *     path="/admins/authUser/{id}",
     *     tags={"Admin"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="admin 的 id",
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
     * 修改一筆 Admin
     * @OA\Put(
     *     path="/admins/authUser/{id}",
     *     tags={"Admin"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="admin 的 id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminModel")
     *
     *          )
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     * Update the specified resource in storage.
     *
     * @param AdminRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AdminRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess('success', $results)
            : $this->jsonFail('fail', $results);
    }

    /**
     * 刪除一筆 Admin
     * @OA\Delete(
     *     path="/admins/authUser/{id}",
     *     tags={"Admin"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="admin 的 id",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="成功")
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

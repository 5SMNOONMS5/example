<?php

namespace Stephenchen\Member\Http\Backend;

use Exception;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

final class MemberController extends BaseController
{
    /**
     * @var MemberService
     */
    private MemberService $service;

    /**
     * Create a new AdminController instance.
     *
     * @param MemberService $service
     */
    public function __construct(MemberService $service)
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

        return $this->jsonSuccess(trans('core::global.success'), $results);
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
     * @return Response
     * @throws Exception
     */
    public function store(UserRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
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
     * @param UserRequest $request
     * @param $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
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

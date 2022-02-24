<?php

namespace Stephenchen\Core\Http\Backend\Banner;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

final class BannerController extends BaseController
{
    /**
     * @var BannerService
     */
    private BannerService $service;

    /**
     * Create a new Controller.
     *
     * @param BannerService $service
     */
    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }

    /**
     * 把 Banner 資料列出來
     * @OA\Get(
     *     path="/admins/banners",
     *     tags={"Banner"},
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

        return $this->jsonSuccess(trans('core::global.success'),  $results);
    }

    /**
     * 新增 Banner, permission 也一並傳近來新增
     * @OA\Post(
     *     path="/admins/banners",
     *     tags={"Banner"},
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
    public function store(BannerRequest $request)
    {
        $results = $this->service->store($request->all());

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 查看一筆 Banner, 會把 permissions 一起回傳
     * @OA\Get(
     *     path="/admins/banners/{id}",
     *     tags={"Banner"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="banner 的 id",
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
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 修改一筆 Banner, permission 也一並傳近來一起修改
     * @OA\Put(
     *     path="/admins/banners/{id}",
     *     tags={"Banner"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="banner 的 id",
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
     * @param BannerRequest $request
     * @param $id
     * @return Response
     */
    public function update(BannerRequest $request, $id)
    {
        $results = $this->service->update($request->all(), $id);

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 刪除一筆 Banner
     * @OA\Delete(
     *     path="/admins/banners/{id}",
     *     tags={"Banner"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="banner 的 id",
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
            ? $this->jsonSuccess(trans('core::global.success'),  $results)
            : $this->jsonFail(trans('core::global.fail'));
    }
}

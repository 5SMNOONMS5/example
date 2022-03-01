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
     * 新增 Banner
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
     *              @OA\Schema(ref="#/components/schemas/BannerModel")
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
     * 查看一筆 Banner
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
     * 修改一筆 Banner
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
     *              @OA\Schema(ref="#/components/schemas/BannerModel")
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

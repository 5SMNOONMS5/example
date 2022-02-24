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
}

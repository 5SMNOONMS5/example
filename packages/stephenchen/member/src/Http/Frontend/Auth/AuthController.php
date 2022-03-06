<?php

namespace Stephenchen\Memb\Http\Backend\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

final class AuthController extends BaseController
{
    /**
     * @var AuthService
     */
    private AuthService $service;

    /**
     * Create a new AuthController instance.
     *
     * @param AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * 後台登入，測試帳密是 admin 或者 admin@gmail.com, 123456，登入之後請在打 me 這隻 api 拿到當前使用者資訊
     * @OA\Post(
     *     path="/admins/login",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="primary",
     *         in="query",
     *         description="信箱 or 帳號",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="密碼",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @param  $request
     * @return Response
     * @throws Exception
     */
    public function login(Request $request)
    {
        $results = $this->service->attempt($request->all());

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * 拿到 admin 使用者的相關資料
     * @OA\Get(
     *     path="/admins/me",
     *     tags={"Auth"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Response(response="200", description="成功")
     * )
     * Get the authenticated User
     */
    public function me()
    {
        $results = $this->service->me();

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * Log the user out (Invalidate the token)
     * @OA\Delete(
     *     path="/admins/logout",
     *     tags={"Auth"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="信箱",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="密碼",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @throws Exception
     */
    public function logout()
    {
        $results = $this->service->logout();

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
    }

    /**
     * Refresh a token.
     * @OA\Get(
     *     path="/admins/refresh",
     *     tags={"Auth"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="信箱",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="密碼",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(response="200", description="成功")
     * )
     *
     * @throws Exception
     */
    public function refresh()
    {
        $results = $this->service->refresh();

        return ( $results )
            ? $this->jsonSuccess(trans('core::global.success'), $results)
            : $this->jsonFail(trans('core::global.fail'));
    }
}


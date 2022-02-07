<?php

namespace Stephenchen\Core\Http\Backend\Admin\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stephenchen\Core\Base\BaseController;

final class AuthController extends BaseController
{
    /**
     * @var AuthService
     */
    private AuthService $service;

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
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $results = $this->service->attempt($request->all());

        return ( $results )
            ? parent::jsonSuccess('success', $results)
            : parent::jsonFail('fail');
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
        $result = $this->service->me();

        return ( $result )
            ? parent::jsonSuccess('success', $result)
            : parent::jsonFail('fail');
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
        $result = $this->service->logout();

        return ( $result )
            ? parent::jsonSuccess('success', $result)
            : parent::jsonFail('fail');
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
        $result = $this->service->refresh();

        return ( $result )
            ? parent::jsonSuccess('success', $result)
            : parent::jsonFail('fail');
    }
}


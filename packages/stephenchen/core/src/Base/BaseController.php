<?php

namespace Stephenchen\Core\Base;

use Stephenchen\Core\Traits\ResponseJsonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     title="後端專案",
 *     description="
 *     後端專案專用的 ＡＰＩ 文件,
 *     請先透過 auth 分類中的 login 登入拿到 token
 *     在到右邊的 Authorize 按鈕中中設定，方可使用所有有鎖頭的 api
 *     然後有鎖頭的 ＡＰＩ 要在 http header 帶 token 進去
 *     ",
 *     version="1.0",
 *     @OA\Contact(
 *         name="stephen chen",
 *         email="tasb00429@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * )
 */
class BaseController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        ResponseJsonTrait;
}


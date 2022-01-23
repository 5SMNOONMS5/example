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
 *     description="後端專案專用的 ＡＰＩ 文件",
 *     version="1.0",
 *     @OA\Contact(
 *         name="",
 *         email="tasb00429@gmail.com"
 *     ),
 * )
 */
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
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


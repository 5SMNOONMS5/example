<?php

namespace Stephenchen\Core\Service\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ResponseObject
 *
 * @package App\Service\Response
 */
final class ResponseObject
{
    /**
     * Response 成功回傳
     *
     * @param       $message
     * @param array $result
     * @param array $custom
     *
     * @return JsonResponse
     */
    public static function success($message, $result = [], $custom = [])
    {
        $default = [
            'code' => 200,
            'msg'  => $message,
            'data' => $result,
        ];

        $output = array_merge($default, $custom);

        return response()->json($output);
    }


    /**
     * Response 失敗回傳
     *
     * @param       $message
     * @param int   $code
     * @param array $custom
     *
     * @return Response
     */
    public static function fail($message, $code = 400, $custom = [])
    {
        $default = [
            'code' => $code,
            'msg'  => $message,
            'data' => $custom,
        ];

        $output = array_merge($default, $custom);

        return response($output, $code);
}
}

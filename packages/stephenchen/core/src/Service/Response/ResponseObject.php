<?php

namespace Stephenchen\Core\Service\Response;

use Illuminate\Http\Response;

final class ResponseObject
{
    /**
     * Response 成功回傳
     *
     * @param       $message
     * @param array $result
     * @param array $custom
     * @return Response
     */
    public static function success($message, $result = [], $custom = [])
    {
        $default = [
            'code' => 200,
            'msg'  => $message,
            'data' => $result,
        ];

        $output = array_merge($default, $custom);
        return response($output, 200);
    }

    /**
     * Response 失敗回傳
     *
     * @param       $message
     * @param int $code
     * @param array $custom
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

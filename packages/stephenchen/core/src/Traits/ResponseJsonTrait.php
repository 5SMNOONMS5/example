<?php

namespace Stephenchen\Core\Traits;

use Illuminate\Http\Response;
use Stephenchen\Core\Service\Response\ResponseObject;

trait ResponseJsonTrait
{
    /**
     * Success response data format
     *
     * @param string $message
     * @param array $results
     * @param array $custom
     * @return Response
     */
    public static function jsonSuccess($message, $results = [], $custom = [])
    {
        return ResponseObject::success($message, $results, $custom);
    }

    /**
     * Fail response
     *
     * @param       $message
     * @param int $code
     * @param array $custom
     * @return Response
     */
    public static function jsonFail($message, $code = 400, $custom = [])
    {
        return ResponseObject::fail($message, $code, $custom);
    }
}

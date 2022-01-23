<?php

namespace Stephenchen\Core\Traits;

use Stephenchen\Core\Service\Response\ResponseObject;
use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseJsonTrait
 *
 * @package App\Traits
 */
trait ResponseJsonTrait
{
    /**
     * Success response data format
     *
     * @param       $message
     * @param array $results
     * @param array $custom
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public static function jsonFail($message, $code = 400, $custom = [])
    {
        return ResponseObject::fail($message, $code, $custom);
    }
}

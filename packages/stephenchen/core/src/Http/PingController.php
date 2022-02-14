<?php

namespace Stephenchen\Core\Http;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Stephenchen\Core\Base\BaseController;
use Stephenchen\Core\Traits\ResponseJsonTrait;

final class PingController extends BaseController
{
    use ResponseJsonTrait;

    /**
     * Responds with a status for heath check.
     *
     * @return JsonResponse
     */
    public function success()
    {
        return self::jsonSuccess('success', [
            'Http method' => request()->method(),
            'Source'      => 'This ping is design for check server alive',
            'Name'        => env('APP_NAME', '沒有名稱, 請詳讀 Readme 檔案，又或者 env 檔案少了 APP_NAME 這個 KEY'),
            'Timestamp'   => Carbon::now(),
            'Source URL'  => request()->fullUrl(),
            'Software'    => request()->server()[ 'SERVER_SOFTWARE' ],
        ]);
    }

    /**
     * Responds with error code
     *
     * @return JsonResponse
     */
    public function error()
    {
        return self::jsonFail('Error message', 400);
    }
}



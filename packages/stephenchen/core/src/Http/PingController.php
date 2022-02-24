<?php

namespace Stephenchen\Core\Http;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;
use Stephenchen\Core\Traits\ResponseJsonTrait;

final class PingController extends BaseController
{
    use ResponseJsonTrait;

    /**
     * Responds with a status for heath check.
     *
     * @return Response
     */
    public function success()
    {
        return $this->jsonSuccess('success', [
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
     * @return Response
     */
    public function error()
    {
        return $this->jsonFail('Error message', 400);
    }
}



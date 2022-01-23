<?php

namespace Stephenchen\Core\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Stephenchen\Core\Traits\ResponseJsonTrait;
use Stephenchen\Core\Traits\SignatureTrait;

final class SignatureGuard
{
    use ResponseJsonTrait,
        SignatureTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $host     = $request->getHost();
        $mixinKey = env('MIX_APP_KEY');

        // 正式站，但如果 Is-Debug 等於當前的 MIX_APP_KEY 的 key 的話也會放行通過
        if ($request->header('Is-Debug') == $mixinKey) {
            return $next($request);
        }

        // 方便本地開發使用：）以及 demo 站使用
        $whiteLists = ['admin.newoil.com.tw'];
        if ($host == '127.0.0.1' ||
            $host == 'localhost' ||
            in_array($request->getSchemeAndHttpHost(), $whiteLists) ||
            App::environment(['staging', 'local'])) {
            return $next($request);
        }

        $errorBag = '';

        if (!$request->hasHeader('Accept')) {
            $errorBag = $errorBag . ', Accept';
        }

        if (!$request->hasHeader('Secret')) {
            $errorBag = $errorBag . ', Secret';
        }

        if (!$request->hasHeader('User-Agent')) {
            $errorBag = $errorBag . ', User-Agent';
        }

        if ($errorBag) {
            $errorBag = 'Missing parameters: ' . $errorBag;
            Log::error('加密失敗', "API 少了參數 {$errorBag} ");
            throw new AuthenticationException($errorBag);
        }

        // 拿到前端組好的 header 中的 Secret 的值跟本地的對比，一樣才放行
        $secretInHeader = $request->header('Secret') ?? NULL;
        // @TIP: 這邊跟前端通勾好，小心別把檔案也一起加密，如果使用 $request->all() 的話，源碼裡面是會把檔案一起加密的
        $value = $this->hash($request->input(), $mixinKey);

        if ($value != $secretInHeader) {
            $message = Config::get('message.fail.verify');
            Log::error('加密失敗', "Server 端加密使用此 {$mixinKey} 來 hash , 產生的值是 {$value} \n, 但是前端使用 {$secretInHeader}");
            Log::error("Server 端加密使用以下參數加密", $request->input());
            throw new AuthenticationException($message);
        }

        return $next($request);
    }
}

<?php

namespace Stephenchen\Core\Http\Middleware;

use App\Service\Cache\CacheService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

final class Cache
{
    /**
     * Cache tags
     * https://laravel.com/docs/8.x/cache#storing-tagged-cache-items
     */
    CONST TAGS_BANNER = "TAGS_BANNER";
    CONST TAGS_PRODUCT = "TAGS_PRODUCT";
    CONST TAGS_CATEGORY = "TAGS_CATEGORY";
    CONST TAGS_BOOTSTRAP = "TAGS_BOOTSTRAP";
    CONST TAGS_CONTACT = "TAGS_CONTACT";
    CONST TAGS_LANGUAGE = "TAGS_LANGUAGE";
    CONST TAGS_BASIC = "TAGS_BASIC";
    CONST TAGS_OTHER = "TAGS_OTHER";
    CONST TAGS_TAGS = "TAGS_TAGS";
    CONST TAGS_SOCIALITES = 'TAGS_SOCIALITES';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed $tags
     * @return mixed
     */
    public function handle($request, Closure $next, $tags = self::TAGS_OTHER)
    {
        // 測試環境直接通過
        // 假如在 Is-Debug 輸入當前 env 裡的 MIX_APP_KEY 的 key 的話也通過
        // 不論正式或者測試，此舉為了方便測試 請通知前端人員盡量不要這樣用
        $sameKey = $request->header('Is-Debug') == env('MIX_APP_KEY');
        if (!env('APP_DEBUG') || $sameKey) {
            return $next($request);
        }

        /*
             不是 GET 跟 HEAD 都略過
             來源根據 HTTP 1.1 RFC 2616 S. 9.1
             https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.1
         */
        if (!$request->isMethodCacheable()) {
            return $next($request);
        }

        /*
             Get Http eTag，這邊會去抓 if_none_match 的 header
             eTag 可以多值，所以回傳 array
             根據來源
             https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag#directives
         */
        $eTags = $request->getETags();

        /*
             這邊會關係到兩個新的概念 Weak validation （ 弱驗證 ）跟 Strong validation （ 強驗證 ）
             Weak validation 會長這樣

                  W/"hash-value"

             Strong validation 會長這樣

                  "hash-value"

             大致邏輯就是

                  一個人去銀行，今天穿紅色衣服，明天他又去銀行，穿了藍色
                  Weak validation 下，他是同位
                  Strong validation 是不同位，因為衣服不一樣

             假如因為某些原因 (註1) 導致我收到 W/"hash-value" 我希望他跟 "hash-value" 是同樣，就會把 w/ 拿掉

             ```(註1)````
             原因情境我也尚未遇到，以下是我找到的資料
             if nginx dynamically gzip your content, it it will convert your ETags into weak ones.
             來源 https://stackoverflow.com/questions/51973120/where-does-the-w-in-an-etag-appear-from
        */
        $eTags = array_map([$this, 'stripWeakTags'], $eTags);

        // Redis tags
        $tags = is_array($tags) ? $tags : [$tags];

        // 如果 match 到任何一個 key 就回傳
        foreach ($eTags as $eTag) {
            if (CacheService::has($tags, $eTag)) {
                $options[ 'etag' ] = $eTag;
                return ( new Response() )
                    ->setStatusCode(304)
                    ->setCache($options);
            }
        }

        // Get response & content
        $response = $next($request);
        $content  = $response->getContent();

        // 產生 eTag 並且前後加上 雙引號 "
        $eTag = md5($content);
        $eTag = Str::of($eTag)->start('"')->finish('"');

        // Set etag
        $options[ 'etag' ] = $eTag;
        $response->setCache($options);

        // Set public
        $response->setPublic();

        // Set max-age
        $response->setMaxAge(0);

        // Put into redis
        CacheService::put($tags, $eTag, $content, env('CACHE_TTL'));

        return $response;
    }

    /**
     * @param $etag
     * @return string|string[]
     */
    private function stripWeakTags($etag)
    {
        return str_replace('W/', '', $etag);
    }
}

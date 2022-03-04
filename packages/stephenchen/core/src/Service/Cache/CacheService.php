<?php

namespace Stephenchen\Core\Service\Cache;

use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

final class CacheService
{
    /**
     * Is cache has value by given key and tags
     *
     * @param array  $tags
     * @param string $key
     *
     * @return mixed
     */
    public static function has(array $tags, string $key)
    {
        if (( env('APP_ENV') == 'local' )) {
            return Cache::get($key);
        } else {
            return Cache::tags($tags)->has($key);
        }
    }

    /**
     * Get cache by key & tags
     *
     * @param array  $tags
     * @param string $key
     *
     * @return mixed
     */
    public static function get(array $tags, string $key)
    {
        if (( env('APP_ENV') == 'local' )) {
            return Cache::get($key);
        } else {
            return Cache::tags($tags)->get($key);
        }
    }

    /**
     * Set value with key
     *
     * @param array                                $tags
     * @param string                               $key
     * @param                                      $value
     * @param DateTimeInterface|DateInterval|int   $ttl 默認 60 分鐘
     */
    public static function put(array $tags, string $key, $value, $ttl = 3600)
    {
        // 本地是用 database 當作 cache drive，然後 database 不支援 tags
        if (env('APP_ENV') == 'local') {
            Cache::put($key, $value, $ttl);
        } else {
            Cache::tags($tags)->put($key, $value, $ttl);
        }
    }

    /**
     * Flush cache with tags or flush entire cache
     *
     *
     * @param array $tags
     */
    public static function flush($tags = NULL)
    {
        if (!$tags) {
            Cache::flush();
            return;
        }
        $tags = is_array($tags) ? $tags : [$tags];
        if (env('APP_ENV') == 'local') {
            Cache::flush();
        } else {
            Cache::tags($tags)->flush();
        }
    }

    /**
     * @param object $target
     * @param string $name
     *
     * @return string|null
     * @deprecated Old methods, archieve it.
     *
     */
    public static function getIdentifier(object $target, string $name): ?string
    {
        // TODO: Implement
        $namespaces = explode("\\", get_class($target));
        $key        = end($namespaces);
        $key        .= ( '_' . $name . '_' );
        $key        = $key . request()->getRequestUri();
        return $key;
    }
}

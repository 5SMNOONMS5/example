<?php

namespace Stephenchen\Core\Utilities;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * Class Helpers
 *
 * @package App\Helpers
 */
final class Helpers
{
    /**
     * Check wether float is between given min and max range
     * cf. https://stackoverflow.com/questions/4684023/how-to-check-if-an-integer-is-within-a-range-of-numbers-in-php
     *
     * @param float $target
     * @param float $min
     * @param float $max
     * @return mixed
     */
    static function isFloatBetween(float $target, float $min, float $max)
    {
        return filter_var(
            $target,
            FILTER_VALIDATE_FLOAT,
            [
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
            ]
        );
    }

    /**
     * Get url query parameters
     *
     * @param $url
     * @return array
     */
    static function retrieveURLQuery($url): array
    {
        $queries = parse_url($url, PHP_URL_QUERY);
        parse_str($queries, $values);
        return $values;
    }

    /**
     * Maybe remove last slash
     *
     * @param $source
     * @return string
     */
    static function maybeRemoveLastSlash(string $source): string
    {
        if (Str::endsWith($source, ' / ')) {
            return substr($source, 0, -1);
        }
        return $source;
    }

    /**
     * Determine if the $source not equal empty or null validation
     *
     * @param $source
     * @return bool
     */
    static function isStringNotEmptyOrNull($source): bool
    {
        return !self::isStringEmptyOrNull($source);
    }

    /**
     * Determine if the $source equal to empty or null validation
     *
     * @param $source
     * @return bool
     */
    static function isStringEmptyOrNull($source): bool
    {
        return ( !isset($source) || trim($source) === '' );
    }

    /**
     * Encoding json
     *
     * @param     $source
     * @param int $options
     * @return string
     */
    static function jsonEncode($source, $options = NULL): string
    {
        return json_encode($source, $options ?? JSON_UNESCAPED_UNICODE);
    }

    /**
     * Encoding json
     *
     * @param      $source
     * @param bool $associative
     * @return array
     */
    static function jsonDecode($source, $associative = TRUE): array
    {
        return json_decode($source, $associative);
    }

    /**
     * Convert array or object to plain string
     *
     * @param array $source
     * @param int $options json encode $options
     * @return string
     */
    static function toString($source, $options = NULL): string
    {
        return ( is_array($source) || is_object($source) )
            ? self::jsonEncode($source, $options)
            : (string)$source;
    }

    /**
     * Combine host and path without worry about slash
     *
     * @param $host
     * @param $path
     * @return string
     */
    static function combineURL($host, $path): string
    {
        // https://stackoverflow.com/questions/5055903/add-trailing-slash-to-url
        $prefix = rtrim($host, '/') . '/';
        $path   = ltrim($path, '/');

        return "{$prefix}{$path}";
    }

    /**
     * Update value in current env file
     *
     * @param $key
     * @param $value
     */
    static function updatePermanentEnvValue($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('=' . env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }

    /**
     * Check array has key
     *
     * @param array $source
     * @param string $key
     * @return bool
     */
    static function isArrayHasKey(?array $source, string $key): bool
    {
        if (is_null($source)) {
            return FALSE;
        }

        return isset($source) && array_key_exists($key, $source);
    }

    /**
     * Dump and die error log while app env is not production
     *
     * @param string $description
     * @param Exception $exception
     * @return void
     */
    static function maybeDD(string $description, Exception $exception)
    {
        if (!App::environment('production')) {
            dd($description, $exception->getMessage(), $exception->getTraceAsString());
        }
    }
}

<?php

namespace Stephenchen\Core\Traits;

use Exception;
use Illuminate\Support\Facades\App;

trait HelperTrait
{
    /**
     * Check array has key
     *
     * @param array  $source
     * @param string $key
     *
     * @return bool
     */
    private function isArrayHasKey(?array $source, string $key): bool
    {
        if (is_null($source)) {
            return FALSE;
        }

        return isset($source) && array_key_exists($key, $source);
    }

    /**
     * Dump and die error log while app env is not production
     *
     * @param string    $description
     * @param Exception $exception
     *
     * @return void
     */
    private function maybeDD(string $description, Exception $exception)
    {
        if (!App::environment('production')) {
            dd($description, $exception->getMessage(), $exception->getTraceAsString());
        }
    }
}



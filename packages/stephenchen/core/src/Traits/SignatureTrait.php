<?php

namespace Stephenchen\Core\Traits;

use Illuminate\Support\Arr;
use Stephenchen\Core\Service\Signature\Signature;

trait SignatureTrait
{
    /**
     * Merge signature $attributes with given $key
     *
     * @param $attributes
     * @param $key
     * @return array
     */
    public function merge($attributes, $key): array
    {
        $values = $this->hash($attributes, $key);
        return array_merge($attributes, [
            'sign' => $values,
        ]);
    }

    /**
     * Encode given attributes with given key
     *
     * @param $attributes
     * @param $key
     * @return string
     */
    private function hash($attributes, $key): string
    {
        return ( new Signature($attributes, $key) )
            ->convertNullToEmptyString()
            ->hash()
            ->getSignaturedValue();
    }

    /**
     * Verify signature
     *
     * @param $attributes
     * @param $key
     * @return bool
     */
    public function verifySignature($attributes, $key): bool
    {
        if (!$sign = Arr::get($attributes, 'sign')) {
            return FALSE;
        }

        $attributes = Arr::except($attributes, ['sign']);
        $values     = $this->hash($attributes, $key);

        return $values == $sign;
    }
}

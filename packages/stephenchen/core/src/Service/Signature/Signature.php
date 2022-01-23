<?php

namespace Stephenchen\Core\Service\Signature;

use Stephenchen\Core\Utilities\Helpers;

/**
 * Class Signature
 *
 * @package App\Services\Signature
 */
final class Signature
{
    /**
     * @var string
     */
    private string $signaturedValue;

    /**
     * @var array
     */
    private array $attributes;

    /**
     * @var string
     */
    private string $privateKey;

    /**
     * Signature constructor.
     *
     * @param array $attributes
     * @param string $privateKey
     */
    public function __construct(array $attributes, string $privateKey)
    {
        $this->attributes = $attributes;
        $this->privateKey = $privateKey;
    }

    /**
     * Convert null to empty string
     *
     * @return Signature
     */
    public function convertNullToEmptyString(): self
    {
        array_walk_recursive($this->attributes, function (&$item) {
            $item = $item ?? '';
        });

        return $this;
    }

    /**
     * Hash given attributes with given key
     *
     * @return Signature
     */
    public function hash(): self
    {
        ksort($this->attributes);
        $json = Helpers::jsonEncode($this->attributes,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_NUMERIC_CHECK);
        $hmac = hash_hmac('sha512', $json, $this->privateKey);
        $this->setSignaturedValue($hmac);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignaturedValue()
    {
        return $this->signaturedValue;
    }

    /**
     * @param mixed $signaturedValue
     */
    public function setSignaturedValue($signaturedValue): void
    {
        $this->signaturedValue = $signaturedValue;
    }
}

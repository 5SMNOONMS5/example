<?php

namespace Stephenchen\Core\Traits\Model;

use DateTimeInterface;

/**
 * Trait SerializeDateTrait
 *
 * @package App\Traits\Model
 */
trait SerializeDateTrait
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}



<?php

namespace Stephenchen\Core\Traits\Model;

use Illuminate\Database\Query\Builder;

/**
 * Trait EnableTrait
 *
 * @package App\Traits\Model
 */
trait EnableTrait
{
    /**
     * Scope a query for enabled data
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', '=', 1);
    }
}



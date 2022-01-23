<?php

namespace Stephenchen\Core\Traits\Database;

use Illuminate\Database\Schema\Blueprint;

/**
 * Migrate `是否啟用` 的欄位
 */
trait MigrateEnabledTrait
{
    /**
     * Migrate `is_enabled` columns
     *
     * @param Blueprint $table
     *
     * @return void
     */
    public function migrateEnabledColumns(Blueprint $table)
    {
        $table->boolean('is_enabled')->default(1)->index()->comment('是否啟用');
    }
}

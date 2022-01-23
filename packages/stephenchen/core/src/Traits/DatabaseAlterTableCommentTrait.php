<?php

namespace Stephenchen\Core\Traits;

use Illuminate\Support\Facades\DB;

trait DatabaseAlterTableCommentTrait
{
    /**
     * Alter table with comments
     *
     * @param string $table
     * @param string $comment
     * @return void
     */
    public function alterTableComments(string $table, string $comment)
    {
        $table = env('DB_PREFIX') . $table;
        $query = "ALTER TABLE {$table} comment '{$comment}'";
        DB::statement($query);
    }
}

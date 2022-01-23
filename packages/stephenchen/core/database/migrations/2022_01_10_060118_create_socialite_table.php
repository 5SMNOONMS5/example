<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Stephenchen\Core\Traits\Database\MigrateEnabledTrait;
use Stephenchen\Core\Traits\DatabaseAlterTableCommentTrait;

/**
 * Class CreateSocialiteTable
 */
final class CreateSocialiteTable extends Migration
{
    use MigrateEnabledTrait,
        DatabaseAlterTableCommentTrait;

    const TABLE = 'socialites';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $this->migrateEnabledColumns($table);
            $table->string('provider')->unique()->comment('provider 名稱');
            $table->string('complement')->nullable()->comment('備註欄位');
            $table->string('channel_id')->nullable()->comment('Channel ID');
            $table->string('channel_secret')->nullable()->comment('Channel Secret');
            $table->string('callback_urls')->nullable()->comment('回調 URLs');
            $table->timestamps();
        });
        $this->alterTableComments(self::TABLE, '第三方登入的');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}

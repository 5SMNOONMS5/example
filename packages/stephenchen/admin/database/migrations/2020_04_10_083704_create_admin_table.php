<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Stephenchen\Core\Traits\DatabaseAlterTableCommentTrait;

final class CreateAdminTable extends Migration
{
    use DatabaseAlterTableCommentTrait;

    /**
     * @var string
     */
    private string $tableName = 'admins';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            $table->string('account', 30)->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->string('display_name', 50)->comment('顯示名稱');
            $table->string('email')->comment('信箱');

            $table->unsignedSmallInteger('status')->default(1)->comment('後台使用者狀態，詳情請看 code');

            $table->ipAddress('latest_ip')->nullable()->comment('最後登入 ip');
            $table->dateTime('latest_login_at')->nullable()->comment('最後登入時間');

            $table->softDeletes();
            $table->timestamps();
        });
        $this->alterTableComments($this->tableName, '後台使用者');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}

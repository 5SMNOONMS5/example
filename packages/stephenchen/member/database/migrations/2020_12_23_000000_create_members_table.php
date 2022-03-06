<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMembersTable extends Migration
{
    /**
     * Table name
     */
    const TABLE = 'members';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('account')->unique()->comment('帳號');
            // 有可能某些舊專案可能會員沒有 email，所以需要 nullable
            // 目前登入支援第三方登入
            // 如果你是第三方登入的話，一開使會用此 email 來當作你的主 email, 但是隨時歡迎修改
//            $table->string('email')->nullable()->unique()->comment('信箱');
            $table->string('password')->nullable()->comment('密碼');
            $table->string('code')->nullable()->unique();

            $table->unsignedSmallInteger('status')->default(0)->comment('會員狀態');
            $table->unsignedSmallInteger('source')->default(0)->comment('數字分別代表不同的管道來源');
            $table->unsignedSmallInteger('level')->default(1)->comment('會員等級');

            $table->string('preferred_name')->nullable()->comment('暱稱');
            $table->ipAddress('latest_ip')->nullable()->comment('最後登入 ip');
            $table->dateTime('latest_login_at')->nullable()->comment('最後登入時間');
            $table->string('remember_token')->nullable();

            $table->string('email')->unique()->comment('信箱');
            $table->dateTime('email_verified_at')->nullable()->comment('信箱驗證的時間');

            $table->integer('phone')->unique();
            $table->date('phone_verified_at')->nullable();

            // 新增的
            $table->string('last_name');
            $table->string('first_name');
            $table->date('birthday')->nullable();
            $table->string('carrier')->nullable();
            $table->string('sex')->nullable();
            $table->decimal('total_consumption', 15, 2)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
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

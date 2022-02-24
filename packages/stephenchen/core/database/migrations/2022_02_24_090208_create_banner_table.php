<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateBannerTable extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    const TABLE = 'banners';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('path');
            $table->unsignedSmallInteger('status')->default(1)->comment('後台使用者狀態，詳情請看 code');
            $table->timestamps();
        });
        // $this->alterTableComments(self::TABLE, '');
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

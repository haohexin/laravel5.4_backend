<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('code', false, false)->comment('编号');
            $table->string('name')->comment('标题');
            $table->bigInteger('fid', false, false)->unsigned()->default(0)->comment('父级id');
            $table->tinyInteger('level');
            $table->string('url')->comment('跳转地址')->nullable();
            $table->string('permission')->comment('权限')->nullable();
            $table->string('icon')->comment('图标')->nullable();
            $table->string('rank')->comment('排序')->nullable();
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
        Schema::dropIfExists('navigations');
    }
}

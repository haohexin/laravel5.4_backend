<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger ( 'code', false, false )->comment ( '编号' );
            $table->string ( 'name' )->comment ( '标题' );
            $table->bigInteger ( 'fid', false, false )->unsigned ()->default ( 0 )->comment ( '父级id' );
            $table->tinyInteger ( 'level' );
            $table->string ( 'url' )->comment ( '跳转地址' )->nullable();
            $table->string ( 'imgurl' )->comment ( '图片地址' )->nullable();
            $table->string ( 'intro' )->comment ( '简介' )->nullable();
            $table->string ( 'rank' )->comment ( '排序' )->nullable();
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
        Schema::dropIfExists('dictionaries');
    }
}

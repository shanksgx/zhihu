<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');    // 标题
            $table->text('body');   // 问题内容
            $table->integer('user_id')->unsigned();  // 外键user_id
            $table->integer('comments_count')->default(0);  // 评论数
            $table->integer('followers_count')->default(1); // 关注数（问题发布者默认关注，所以默认为1）
            $table->integer('answers_count')->default(0);   // 回答数
            $table->string('close_comment', 8)->default('F');    // 是否关闭评论，默认F没关
            $table->string('is_hidden', 8)->default('F');    // 是否隐藏问题，默认F没隐藏
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
        Schema::dropIfExists('questions');
    }
}

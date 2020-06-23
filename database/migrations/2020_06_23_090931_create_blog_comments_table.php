<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contenu');
            $table->string('image')->nullable();
            $table->unsignedInteger('user_comment_id');
            $table->unsignedInteger('blog_id');
            $table->timestamps();

            $table->foreign('user_comment_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
}

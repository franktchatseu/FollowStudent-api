<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contenu');
            $table->string('image')->nullable();
            $table->unsignedInteger('user_response_id');
            $table->unsignedInteger('comment_id');
            $table->timestamps();

            $table->foreign('user_response_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('comment_id')->references('id')->on('blogs')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_responses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre');
            $table->string('contenu');
            $table->string('image')->nullable();
            $table->unsignedInteger('user_publish_id');
            $table->unsignedInteger('blog_categorie_id');
            $table->timestamps();

            $table->foreign('user_publish_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('blog_categorie_id')->references('id')->on('blog_categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}

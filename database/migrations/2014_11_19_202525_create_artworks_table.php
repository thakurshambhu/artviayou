<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('style')->nullable();
            $table->string('subject')->nullable();
            $table->enum('top',['yes','no'])->default('no');
            $table->enum('trending',['yes','no'])->default('no');
            $table->enum('is_deleted',['yes','no'])->default('no');
            $table->enum('is_publised',['publish','unpublish'])->default('publish');
            $table->timestamps();
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artworks');
    }
}
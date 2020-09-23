<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('media_url')->nullable();
            $table->enum('is_deleted',['yes','no'])->default('no');
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->timestamps();
        });

        Schema::table('artwork_images', function (Blueprint $table) {
            $table->unsignedBigInteger('artwork_id')->after('id');
            $table->foreign('artwork_id')->references('id')->on('artworks')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artwork_images');
    }
}

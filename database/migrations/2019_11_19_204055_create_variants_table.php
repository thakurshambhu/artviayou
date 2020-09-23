<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('variant_type',['original','limited_edition','art_paint'])->default('original');
            $table->string('editions_count')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('price')->nullable();
            $table->string('worldwide_shipping_charge')->nullable();
            $table->enum('not_for_sale',['yes','no'])->default('no');
            $table->enum('is_deleted',['yes','no'])->default('no');
            $table->enum('is_active',['yes','no'])->default('yes'); 
            $table->timestamps();
        });

        Schema::table('variants', function (Blueprint $table) {
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
        Schema::dropIfExists('variants');
    }
}

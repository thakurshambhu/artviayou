<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestComissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_comissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->integer('user_id')->nullable();
            // $table->integer('artist_id')->nullable();
            $table->enum('request_status',['Accepted','Decline'])->nullable();
            $table->timestamps();
        });

        Schema::table('request_comissions', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->after('id')->nullable()->unsigned();
            // $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade')->nullable()->unsigned();
        });

        Schema::table('request_comissions', function (Blueprint $table) {
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
        Schema::dropIfExists('request_comissions');
    }
}

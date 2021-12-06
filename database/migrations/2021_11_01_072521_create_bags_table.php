<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bags', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('productmeta_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->string('showoff_id')->nullable();
            $table->string('customize_message')->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->integer('quantity')->default('1');
           
            $table->timestamps();

            $table->foreign('productmeta_id')->references('id')->on('products_metas')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bags');
    }
}

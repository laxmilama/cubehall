<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('product_id');
            $table->string('colorhex');
            $table->string('colorname');
            $table->string('thumbnail');
            $table->string('descriptionimage');
            $table->string('material');
            $table->string('size');
            $table->integer('stock');
            $table->float('price');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product_lists')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_meta');
    }
}

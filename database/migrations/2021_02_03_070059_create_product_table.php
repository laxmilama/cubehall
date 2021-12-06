<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('section_id');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('collection_id');
            $table->string('name');
            $table->text('description');
            $table->string('meta_title');
            $table->text('details');
            $table->string('slug');
            $table->enum('is_featured',['Yes','No'])->nullable();
            $table->tinyinteger('status');
            $table->timestamps();

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
        Schema::dropIfExists('product');
    }
}

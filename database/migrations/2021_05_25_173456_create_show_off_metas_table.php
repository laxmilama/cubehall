<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowOffMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_off_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_off_id');
            $table->unsignedBigInteger('link_id');
            $table->string('type');
            $table->string('left');
            $table->string('top');
            $table->string('url');
            $table->timestamps();
            $table->foreign('show_off_id')->references('id')->on('show_offs')->onDelete('cascade');
            $table->foreign('link_id')->references('id')->on('product_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('show_off_metas');
    }
}

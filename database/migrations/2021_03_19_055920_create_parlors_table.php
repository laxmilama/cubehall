<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParlorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parlors', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('user_id');
            $table->text('brief', 5000);
            $table->string('title', 60);
            $table->string('theme');
            $table->text('bringings', 5000);
            $table->string('languages');
            $table->text('learnings', 5000);
            $table->string('location');            
            $table->tinyInteger('accuracy');
            $table->tinyInteger('agreeterms');
            $table->tinyInteger('noncopyrightcontent');
            $table->tinyInteger('obaylaws');
            $table->string('cover');
            $table->integer('age');
            $table->text('details', 3000);
            $table->string('video');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parlors');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKYCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_y_c_s', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('type');
            $table->string('front');
            $table->string('back')->nullable();
            $table->string('person');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('verified');
            $table->tinyInteger('checked_at');
            $table->timestamp('checked')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('k_y_c_s');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowOffEarnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_off_earns', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 8,2);
            $table->string('currency');
            $table->unsignedBigInteger('showoff_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status');
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
        Schema::dropIfExists('show_off_earns');
    }
}

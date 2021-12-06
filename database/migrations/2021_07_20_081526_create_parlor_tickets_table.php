<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParlorTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parlor_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parlor_id');
            $table->unsignedFloat('price');
            $table->string('currency');
            $table->string('ticket', 500);
            $table->timestamp('time');
            $table->integer('duration');
            $table->integer('capacity');
            $table->timestamps();
           
            $table->softDeletes();
            $table->foreign('parlor_id')->references('id')->on('parlors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parlor_tickets');
    }
}

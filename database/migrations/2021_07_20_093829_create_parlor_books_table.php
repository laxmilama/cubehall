<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParlorBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parlor_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('parlor_id');
            $table->unsignedBigInteger('booked_id');
            $table->string('payment');
            $table->integer('total_amount');
            $table->integer('quantity');
            $table->tinyinteger('status');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('attended_at')->nullable();
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
        Schema::dropIfExists('parlor_books');
    }
}

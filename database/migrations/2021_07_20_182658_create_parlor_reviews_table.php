<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParlorReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parlor_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parlor_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('ticket_id');
            $table->string('review', 5000);            
            $table->double('rating');
            $table->tinyinteger('status');
            $table->timestamps();

            $table->foreign('parlor_id')->references('id')->on('parlors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('parlor_reviews');
    }
}

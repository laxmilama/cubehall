<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('page_id');
            $table->string('option');
            $table->string('code');
            $table->text('categories');
            $table->string('eligibility')->default('public');
            $table->text('option_meta')->nullable();
            $table->string('type');
            $table->double('percent_off')->nullable();
            $table->float('amount_off')->nullable();
            $table->string('currency');
            $table->timestamp('expires_at');
            $table->integer('times_redeemed');
            $table->integer('max_redemptions'); // number of times user can redem coupon
            $table->tinyinteger('status');
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
        Schema::dropIfExists('coupons');
    }
}

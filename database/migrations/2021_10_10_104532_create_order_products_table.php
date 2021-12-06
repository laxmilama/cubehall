<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('products_meta_id');
            $table->unsignedBigInteger('page_id');
            $table->integer('quantity');
            $table->double('price');
            $table->string('currency');
            $table->double('shipping_charge')->nullable();
            $table->double('coupon')->nullable();
            $table->string('thumbnail');
            $table->string('slug');
            $table->string('product_name');
            $table->string('customize_message')->nullable();
            $table->string('status')->default('New');
            $table->timestamp('requested_at')->nullable();
            $table->string('pickup_note', 500);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('pickup_at')->nullable();
            $table->string('delivery_status')->nullable();
            $table->timestamp('delivered_at')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}

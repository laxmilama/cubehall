<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProshippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proshipping_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('product_list_id');
            $table->unsignedBigInteger('shipping_address_id');
      
 
            $table->foreign('product_list_id')->references('id')->on('product_lists')->onDelete('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses')->onDelete('cascade');
        

            $table->primary(['product_list_id','shipping_address_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proshipping_addresses');
    }
}

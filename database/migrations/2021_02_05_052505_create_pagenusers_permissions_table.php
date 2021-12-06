<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagenusersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagenusers_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('pagenuser_id');
            $table->unsignedBigInteger('permission_id');
 
            $table->foreign('pagenuser_id')->references('id')->on('pagenusers')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
 
            $table->primary(['pagenuser_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagenusers_permissions');
    }
}

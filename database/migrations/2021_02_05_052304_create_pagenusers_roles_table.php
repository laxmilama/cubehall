<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagenusersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagenusers_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('pagenuser_id');
            $table->unsignedBigInteger('role_id');
 
            $table->foreign('pagenuser_id')->references('id')->on('pagenusers')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
 
            $table->primary(['pagenuser_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagenusers_roles');
    }
}

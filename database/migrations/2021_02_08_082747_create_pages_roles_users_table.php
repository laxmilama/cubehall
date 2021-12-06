<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesRolesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_roles_users', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
           
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         
 
            $table->primary(['page_id','role_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_roles_users');
    }
}

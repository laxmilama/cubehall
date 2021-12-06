<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_permissions', function (Blueprint $table) {

            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
 
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['page_id','permission_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_permissions');
    }
}

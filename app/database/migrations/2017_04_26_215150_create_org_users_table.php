<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_users', function (Blueprint $table) {

          $table->increments('id');
          $table->uuid('org_id');
          $table->foreign('org_id')->references('id')->on('orgs')->onDelete('cascade');
          $table->uuid('user_id');
          $table->foreign('user_id')->references('id')->on('users');
          $table->timestamps();
          $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_users');
    }
}

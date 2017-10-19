<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgRolesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('org_roles', function(Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('short_description', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('permissions');
            $table->primary('id');
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
		Schema::drop('org_roles');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pay_items', function(Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('org_id');
            $table->boolean('is_system')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('pay_item_type');
            $table->uuid('account_id');
            $table->boolean('mark_default')->default(0);
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
		Schema::drop('pay_items');
	}

}

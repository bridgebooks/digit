<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sale_items', function(Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('org_id');
            $table->uuid('user_id');
            $table->string('code', 5);
            $table->string('name');

            $table->boolean('is_sold')->default(true);
           	$table->decimal('sale_unit_price', 11, 2)->nullable();
           	$table->uuid('sale_account_id')->nullable();
           	$table->uuid('sale_tax_id')->nullable();
           	$table->text('sale_description')->nullable();;

           	$table->boolean('is_purchased')->default(true);
           	$table->decimal('purchase_unit_price', 11, 2)->nullable();
           	$table->uuid('purchase_account_id')->nullable();
           	$table->uuid('purchase_tax_id')->nullable();
           	$table->text('purchase_description')->nullable();

            $table->softDeletes();
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
		Schema::drop('sale_items');
	}

}

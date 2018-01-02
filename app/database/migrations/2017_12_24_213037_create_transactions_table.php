<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
            $table->uuid('id');
            $table->uuid('org_id');
            $table->morphs('transactable');
            $table->uuid('debit_account_id');
            $table->uuid('credit_account_id');
            $table->decimal('credit', 10,2);
            $table->decimal('debit', 10,2);
            $table->timestamps();

            $table->primary('id');
            $table->index('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}

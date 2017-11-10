<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePaymentsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_payments', function(Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('invoice_id');

            $table->string('transaction_ref');
            $table->string('processor_transaction_ref');

            $table->float('amount', 8, 2);
            $table->float('processor_fee', 8, 2)->default(env('PAYMENT_PROCESSOR_FEE'));
            $table->float('fee', 8, 2)->default(env('PAYMENT_FEE'));

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 15)->nullable();

            $table->string('status')->default('pending');
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
		Schema::drop('invoice_payments');
	}

}

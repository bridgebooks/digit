<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgInvoiceSettingsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('org_invoice_settings', function(Blueprint $table) {
            $table->uuid('id');
            $table->uuid('org_id');
            $table->string('template')->default('standard');
            $table->enum('paper_size', ['a4', 'a3', 'a5', 'letter'])->default('a4');
            $table->uuid('org_bank_account_id')->nullable();
            $table->text('payment_advice')->nullable();
            $table->boolean('show_payment_advice')->default(true);
            $table->timestamps();
            $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('org_invoice_settings');
	}

}

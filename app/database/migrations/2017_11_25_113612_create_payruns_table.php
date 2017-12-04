<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrunsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pay_runs', function(Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('org_id');
            $table->uuid('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('payment_date');
            $table->decimal('wages', 10, 2)->default(0.00);
            $table->decimal('deductions', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('reimbursements', 10, 2)->default(0.00);
            $table->decimal('net_pay', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft','approved', 'paid', 'voided'])->default('draft');
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
		Schema::drop('pay_runs');
	}

}

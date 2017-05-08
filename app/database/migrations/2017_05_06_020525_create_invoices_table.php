<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {

          $table->uuid('id');
          $table->uuid('org_id');
          $table->uuid('user_id')->nullable();
          $table->enum('type', ['acc_pay', 'acc_rec'])->default('acc_pay');
          $table->uuid('contact_id');
          $table->integer('currency_id')->unsigned();
          $table->string('invoice_no');
          $table->string('reference')->nullable();
          $table->enum('line_amount_type', ['exclusive', 'inclusive', 'no_tax'])->default('inclusive');
          $table->enum('status', ['draft', 'submitted', 'authorized', 'sent', 'paid', 'voided'])->default('draft');
          $table->dateTime('due_at')->nullable();
          $table->timestamps();
          $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}

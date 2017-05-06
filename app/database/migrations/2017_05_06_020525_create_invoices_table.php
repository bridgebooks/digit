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
          $table->uuid('contact_id');
          $table->string('invoice_no');
          $table->string('reference')->nullable();
          $table->string('status')->default('draft');
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

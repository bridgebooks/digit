<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->dropColumn('processor_transaction_ref');
        });

        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->string('processor_transaction_ref')->nullable()->after('transaction_ref');
            $table->string('invoice_type')->after('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->dropColumn('invoice_type');
            $table->string('processor_transaction_ref')->after('transaction_ref');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceAmountFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('sub_total', 11, 2)->default(0.00)->after('status');
            $table->decimal('tax_total', 11, 2)->default(0.00)->after('sub_total');
            $table->decimal('total', 11, 2)->default(0.00)->after('tax_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->dropColumn('tax_total');
            $table->dropColumn('total');
        });
    }
}

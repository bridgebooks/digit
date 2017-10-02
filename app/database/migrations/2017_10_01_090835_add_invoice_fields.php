<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dateTime('raised_at')->nullable()->after('due_at');
            $table->text('notes')->nullable()->after('raised_at');
            $table->dropColumn('currency_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('currency_id')->unsigned()->nullable();
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
            $table->dropColumn('raised_at');
            $table->dropColumn('notes');
        });
    }
}

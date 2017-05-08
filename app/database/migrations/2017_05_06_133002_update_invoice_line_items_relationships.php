<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceLineItemsRelationships extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::table('invoice_line_items', function (Blueprint $table) {

        $table->foreign('invoice_id')->references('id')->on('invoices');
        $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
        $table->foreign('account_id')->references('id')->on('accounts');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if(Schema::hasTable('invoice_line_itmes')) {

        Schema::table('invoice_line_itmes', function (Blueprint $table) {
          $table->dropForeign('invoice_line_items_invoice_id_foreign');
          $table->dropForeign('invoice_line_items_tax_rate_id_foreign');
          $table->dropForeign('invoice_line_items_account_id_foreign');
        });
    }
  }
}

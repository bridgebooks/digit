<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceRelationships extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::table('invoices', function (Blueprint $table) {

        $table->foreign('org_id')->references('id')->on('orgs');
        $table->foreign('user_id')->references('id')->on('users');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if(Schema::hasTable('invoices')) {

        Schema::table('invoices', function (Blueprint $table) {
          $table->dropForeign('invoices_org_id_foreign');
          $table->dropForeign('invoices_user_id_foreign');
        });
    }
  }
}

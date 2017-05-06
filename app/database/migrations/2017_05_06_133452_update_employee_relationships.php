<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('employees', function (Blueprint $table) {
        $table->foreign('org_id')->references('id')->on('orgs');
        $table->foreign('bank_id')->references('id')->on('banks');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if(Schema::hasTable('employees')) {

        Schema::table('employees', function (Blueprint $table) {
          $table->dropForeign('employeees_org_id_foreign');
          $table->dropForeign('employeees_bank_id_foreign');
        });
      }
    }
}

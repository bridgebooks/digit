<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrgsRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orgs', function (Blueprint $table) {

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
      if(Schema::hasTable('orgs')) {

          Schema::table('orgs', function (Blueprint $table) {
            $table->dropForeign('orgs_bank_id_foreign');
          });
      }
    }
}

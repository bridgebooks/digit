<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContactGroupRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('contact_groups', function (Blueprint $table) {
        $table->foreign('org_id')->references('id')->on('orgs');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if(Schema::hasTable('contact_groups')) {

        Schema::table('contact_groups', function (Blueprint $table) {
          $table->dropForeign('contact_groups_org_id_foreign');
        });
      }
    }
}

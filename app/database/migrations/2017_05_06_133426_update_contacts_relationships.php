<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContactsRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('contacts', function (Blueprint $table) {
        $table->foreign('org_id')->references('id')->on('orgs');
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('contact_group_id')->references('id')->on('contact_groups');
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
        if(Schema::hasTable('contacts')) {

          Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_org_id_foreign');
            $table->dropForeign('contacts_user_id_foreign');
            $table->dropForeign('contacts_contact_group_id_foreign');
            $table->dropForegin('contacts_bank_id_foreign');
          });
        }
    }
}

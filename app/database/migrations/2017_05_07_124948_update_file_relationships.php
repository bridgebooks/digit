<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFileRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
          $table->foreign('org_id')->references('id')->on('orgs');
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('folder_id')->references('id')->on('file_folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('files')) {
          Schema::table('files', function (Blueprint $table) {
            $table->dropForeign('files_org_id_foreign');
            $table->dropForeign('files_user_id_foreign');
            $table->dropForeign('files_folder_id_foreign');
          });
        }
    }
}

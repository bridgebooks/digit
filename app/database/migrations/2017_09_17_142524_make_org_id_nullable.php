<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeOrgIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {

            $table->dropForeign('accounts_org_id_foreign');
            $table->dropForeign('accounts_tax_rate_id_foreign');
            $table->dropColumn('org_id');
            $table->dropColumn('tax_rate_id');
        });

        Schema::table('accounts', function (Blueprint $table) {

            $table->uuid('org_id')->nullable()->after('account_type_id');
            $table->uuid('tax_rate_id')->nullable()->after('description');
            $table->foreign('org_id')->references('id')->on('orgs');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->uuid('org_id')->after('account_type_id');
            $table->uuid('tax_rate_id')->after('description');
        });
    }
}

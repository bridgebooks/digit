<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxRateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropForeign('tax_rates_org_id_foreign');
        });

        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropColumn('org_id');
        });

        Schema::table('tax_rates', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->uuid('org_id')->nullable()->after('is_system');
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
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}

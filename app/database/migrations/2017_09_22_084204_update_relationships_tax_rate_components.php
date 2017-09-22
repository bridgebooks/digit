<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationshipsTaxRateComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tax_rate_components', function (Blueprint $table) {
            $table->dropForeign('tax_rate_components_tax_rate_id_foreign');
        });

        Schema::table('tax_rate_components', function (Blueprint $table) {
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tax_rate_components', function (Blueprint $table) {
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
        });
    }
}

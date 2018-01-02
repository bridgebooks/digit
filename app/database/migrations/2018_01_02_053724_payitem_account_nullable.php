<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayitemAccountNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_items', function (Blueprint $table) {

            $table->dropColumn('account_id');
        });

        Schema::table('pay_items', function (Blueprint $table) {

            $table->uuid('account_id')->nullable()->after('default_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_items', function (Blueprint $table) {
            $table->uuid('account_id')->after('default_amount');
        });
    }
}

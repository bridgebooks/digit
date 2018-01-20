<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->renameColumn('interval', 'invoice_interval')->alter();
        });

        Schema::table('plans', function (Blueprint $table)  {

           $table->smallInteger('invoice_period')->unsigned()->default(1)->after('invoice_interval');
           $table->string('trial_interval', 10)->default('day')->after('invoice_period');
           $table->smallInteger('trial_period')->unsigned()->default(30)->after('trial_interval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table)  {
            $table->renameColumn('invoice_interval', 'interval');
            $table->dropColumn('invoice_period');
            $table->dropColumn('trial_period');
            $table->dropColumn('trial_interval');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('gender', [ 'male', 'female' ])
                ->after('last_name')
                ->nullable();
            $table->date('date_of_birth')
                ->nullable()
                ->after('gender');
            $table->date('start_date')
                ->after('country')
                ->nullable();
            $table->date('termination_date')
                ->after('start_date')
                ->nullable();
            $table->enum('status', [ 'active', 'terminated' ])
                ->after('bank_account_name')
                ->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('start_date');
            $table->dropColumn('termination_date');
            $table->dropColumn('status');
        });
    }
}

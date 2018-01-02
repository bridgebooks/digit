<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgPayrunSettings extends Migration
{
    protected $defaultValues = [
        'wages_account' => null,
        'employee_tax_account' => null,
        'basic_wage_item' => null,
        'housing_allowance_item' => null,
        'transport_allowance_item' => null,
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_payrun_settings', function (Blueprint $table) {
           $table->uuid('id');
           $table->uuid('org_id');
           $table->text('values', json_encode($this->defaultValues));
           $table->timestamps();
           $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('org_payrun_settings');
    }
}

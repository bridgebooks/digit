<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxRateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rate_components', function (Blueprint $table) {

          $table->uuid('id');
          $table->uuid('tax_rate_id');
          $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
          $table->string('name');
          $table->float('value');
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
        Schema::dropIfExists('tax_rate_components');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orgs', function(Blueprint $table) {

            $table->uuid('id');
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('business_reg_no')->nullable();
            $table->integer('industry_id')->unsigned();
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->string('description', 300)->nullable();
            $table->string('logo_url')->nullable();
            $table->string('address')->nullable();
            $table->string('city_town')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('orgs');
    }
}

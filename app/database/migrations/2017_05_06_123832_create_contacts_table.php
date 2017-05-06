<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {

          $table->uuid('id');
          $table->uuid('org_id');
          $table->uuid('contact_group_id')->nullable();
          $table->string('type')->default('customer');
          
          $table->string('name');
          $table->string('phone')->nullable();
          $table->string('website')->nullable();

          $table->string('address_line_1')->nullable();
          $table->string('address_line_2')->nullable();
          $table->string('city_town')->nullable();
          $table->string('state_region')->nullable();
          $table->string('postal_zip')->nullable();
          $table->string('country')->nullable();

          $table->uuid('bank_id')->nullable();
          $table->string('bank_account_no', 20)->nullable();
          $table->string('bank_account_name')->nullable();

          $table->timestamps();
          $table->softDeletes();
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
        Schema::dropIfExists('contacts');
    }
}

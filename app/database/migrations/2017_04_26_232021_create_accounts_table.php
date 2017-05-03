<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {

          $table->uuid('id');
          $table->boolean('is_system')->default(false);
          $table->integer('account_type_id')->unsigned();
          $table->foreign('account_type_id')->references('id')->on('account_types');
          $table->uuid('org_id');
          $table->foreign('org_id')->references('id')->on('orgs');
          $table->string('code', 10);
          $table->string('name');
          $table->string('description')->nullable();
          $table->uuid('tax_rate_id');
          $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
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
        Schema::dropIfExists('accounts');
    }
}

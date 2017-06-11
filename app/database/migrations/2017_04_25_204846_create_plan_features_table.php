<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('subscription_features', function (Blueprint $table) {

         $table->uuid('id');
         $table->uuid('plan_id');
         $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');;
         $table->string('name');
         $table->string('value');
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
        Schema::dropIfExists('plan_features');
    }
}

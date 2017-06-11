<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('subscription_usages', function (Blueprint $table) {

          $table->uuid('id');
          $table->uuid('subscription_id');
          $table->uuid('feature_id');
          $table->smallInteger('used')->unsigned();
          $table->timestamps();

          $table->primary('id');

          $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_usages');
    }
}

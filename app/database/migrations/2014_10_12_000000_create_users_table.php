<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->uuid('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('paystack_customer_code', 25)->nullable();
            $table->string('card_brand', 4)->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_exp_month', 2)->nullable();
            $table->string('card_exp_year', 4)->nullable();
            $table->string('authorization_code', 20)->nullable();
            $table->string('verification_token', 32)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->timestamp('trial_ends_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}

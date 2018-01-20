<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscriptionNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('paystack_subscription_code');
            $table->dropColumn('paystack_subscription_token');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
           $table->string('paystack_subscription_code')->nullable()->after('plan_id');
           $table->string('paystack_subscription_token')->nullable()->after('paystack_subscription_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('paystack_subscription_code')->after('plan_id');
            $table->string('paystack_subscription_token')->after('paystack_subscription_code');
        });
    }
}

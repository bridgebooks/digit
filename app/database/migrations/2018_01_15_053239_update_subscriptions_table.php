<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function(Blueprint $table) {
            $table->timestamp('starts_at')->nullable()->after('trial_ends_at');
            $table->timestamp('canceled_at')->nullable()->after('ends_at');
            $table->timestamp('cancels_at')->nullable()->after('canceled_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function(Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('canceled_at');
            $table->dropColumn('cancels_at');
        });
    }
}

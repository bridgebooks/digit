<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrgAccountSettingsTable.
 */
class CreateOrgAccountSettingsTable extends Migration
{
	protected $defaultValues = [
        'accounts_recievable' => null,
        'accounts_payable' => null,
        'sales_tax' => null
    ];
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('org_account_settings', function(Blueprint $table) {
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
		Schema::drop('org_account_settings');
	}
}

<?php

use Illuminate\Database\Seeder;
use App\Models\AccountType;

class AccountTypesTableSeeder extends Seeder
{
	protected $types = [
		[
			'name' => 'Assets',
			'normal_balance' => 'debit'
		],
		[
			'name' => 'Liabilities',
			'normal_balance' => 'credit'
		],
		[
			'name' => 'Expenses',
			'normal_balance' => 'debit'
		],
		[
			'name' => 'Equity',
			'normal_balance' => 'credit'
		],
		[
			'name' => 'Revenue',
			'normal_balance' => 'credit'
		]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->types as $type) {
        	$accountType = new AccountType();

        	$accountType->name = $type['name'];
        	$accountType->normal_balance = $type['normal_balance'];

        	$accountType->save();
        }
    }
}

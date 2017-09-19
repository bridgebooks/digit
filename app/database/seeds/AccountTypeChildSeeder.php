<?php

use Illuminate\Database\Seeder;
use App\Models\AccountType;

class AccountTypeChildSeeder extends Seeder
{
	protected $assetAccounts = [
		[ 'name' => 'Current Asset', 'normal_balance' => 'debit' ],
		[ 'name' => 'Non-Current Asset', 'normal_balance' => 'debit' ],
		[ 'name' => 'Fixed Asset', 'normal_balance' => 'debit' ],
		[ 'name' => 'Inventory', 'normal_balance' => 'debit' ]
	];

	protected $liabilityAccounts = [
		[ 'name' => 'Current Liability', 'normal_balance' => 'credit' ],
		[ 'name' => 'Liability', 'normal_balance' => 'credit' ],
		[ 'name' => 'Non-Current Liability', 'normal_balance' => 'credit' ],
	];

	protected $revenueAccounts = [
		[ 'name' => 'Other Income', 'normal_balance' => 'credit' ],
		[ 'name' => 'Revenue', 'normal_balance' => 'credit' ],
	];

	protected $equityAccounts = [
		[ 'name' => 'Equity', 'normal_balance' => 'credit' ]
	];

	protected $expenseAccounts = [
		[ 'name' => 'Depreciation', 'normal_balance' => 'debit' ],
		[ 'name' => 'Expense', 'normal_balance' => 'debit' ],
		[ 'name' => 'Overhead', 'normal_balance' => 'debit' ],
		[ 'name' => 'Direct Costs', 'normal_balance' => 'debit' ]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = AccountType::where('name','=','Assets')->first();
        $liabilities = AccountType::where('name','=','Liabilities')->first();
        $expenses = AccountType::where('name','=','Expenses')->first();
        $equity = AccountType::where('name','=','Equity')->first();
        $revenue = AccountType::where('name','=','Revenue')->first();

        foreach ($this->assetAccounts as $assetAccount) {
        	$account = new AccountType();
        	$account->name = $assetAccount['name'];
        	$account->normal_balance = $assetAccount['normal_balance'];
        	$account->parent_id = $assets->id;
        	$account->save();
        }

        foreach ($this->liabilityAccounts as $liabilityAccount) {
        	$account = new AccountType();
        	$account->name = $liabilityAccount['name'];
        	$account->normal_balance = $liabilityAccount['normal_balance'];
        	$account->parent_id = $liabilities->id;
        	$account->save();
        }

        foreach ($this->expenseAccounts as $expenseAccount) {
        	$account = new AccountType();
        	$account->name = $expenseAccount['name'];
        	$account->normal_balance = $expenseAccount['normal_balance'];
        	$account->parent_id = $expenses->id;
        	$account->save();
        }

        foreach ($this->equityAccounts as $equityAccount) {
        	$account = new AccountType();
        	$account->name = $equityAccount['name'];
        	$account->normal_balance = $equityAccount['normal_balance'];
        	$account->parent_id = $equity->id;
        	$account->save();
        }

        foreach ($this->revenueAccounts as $revenueAccount) {
        	$account = new AccountType();
        	$account->name = $revenueAccount['name'];
        	$account->normal_balance = $revenueAccount['normal_balance'];
        	$account->parent_id = $revenue->id;
        	$account->save();
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Org;

class AccountsTableSeeder extends Seeder
{
	protected $org;

	protected $accounts = [
		[
			'name' => 'Sales',
			'code' => '100',
			'type' => 'Revenue',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Income from any normal business activity',
		],
		[
			'name' => 'Other Revenue',
			'code' => '110',
			'type' => 'Other Income',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Any other income that does not relate to normal business activities and is not recurring',
		],
		[
			'name' => 'Interest Income',
			'code' => '120',
			'type' => 'Revenue',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Income from interest',
		],
		[
			'name' => 'Purchases',
			'code' => '200',
			'type' => 'Direct Costs',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Goods purchases with the intention of selling to customers',
		],
		[
			'name' => 'Cost of Goods Sold',
			'code' => '210',
			'type' => 'Direct Costs',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Cost of goods sold by the business',
		],
		[
			'name' => 'Advertising',
			'code' => '300',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Advertising expenses',
		],
		[
			'name' => 'Bank Fees',
			'code' => '310',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Fees charged by bank for transactions',
		],
		[
			'name' => 'Consulting & Accounting',
			'code' => '320',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Expenses related to paying consultants',
		],
		[
			'name' => 'Rent',
			'code' => '330',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Expenses on rent for building or area',
		],
		[
			'name' => 'Office Expenses',
			'code' => '340',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'General office related expenses',
		],
		[
			'name' => 'Office Expenses',
			'code' => '350',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'General office related expenses',
		],
		[
			'name' => 'Light, Power, Heating',
			'code' => '360',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Expenses incurred for lighting, powering or heating the premises',
		],
		[
			'name' => 'Wages and Salaries',
			'code' => '370',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Payment to employees in exchange for their resources',
		],
		[
			'name' => 'Subscriptions',
			'code' => '380',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'E.g. Magazines, professional bodies',
		],
		[
			'name' => 'Telephone & Internet',
			'code' => '390',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Expenditure incurred from any business-related phone calls, phone lines, or internet connections',
		],
		[
			'name' => 'Travel - Domestic',
			'code' => '391',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Expenditure on domestic travel for business',
		],
		[
			'name' => 'Travel - International',
			'code' => '392',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'Expenditure on internation travel for business',
		],
		[
			'name' => 'Income Tax Expense',
			'code' => '393',
			'type' => 'Expense',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'A percentage of total earnings paid to the government.',
		],
		[
			'name' => 'Accounts Receivable',
			'code' => '400',
			'type' => 'Current Asset',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Outstanding invoices the company has issued out to the client but has not yet received in cash at balance date.',
		],
		[
			'name' => 'Office Equipment',
			'code' => '400',
			'type' => 'Fixed Asset',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Office equipment that is owned and controller by the business.',
		],
		[
			'name' => 'Computer Equipment',
			'code' => '410',
			'type' => 'Fixed Asset',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Computer equipment that is owned and controller by the business.',
		],
		[
			'name' => 'Accounts Payable',
			'code' => '500',
			'type' => 'Current Liability',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'Outstanding invoices the company has received from suppliers but has not yet paid at balance date',
		],
		[
			'name' => 'Sales Tax',
			'code' => '510',
			'type' => 'Current Liability',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'The balance in this account represents Sales Tax owing to or from your tax authority',
		],
		[
			'name' => 'Employee Tax Payable',
			'code' => '520',
			'type' => 'Current Liability',
			'tax_rate_id' => NULL,
			'is_system' => true,
			'description' => 'The amount of tax that has been deducted from wages or salaries paid to employes and is due to be paid',
		],
		[
			'name' => 'Income Tax Payable',
			'code' => '530',
			'type' => 'Current Liability',
			'tax_rate_id' => NULL,
			'is_system' => false,
			'description' => 'The amount of income tax that is due to be paid, also resident withholding tax paid on interest received.',
		],
	];

	public function __construct(Org $org)
	{
		$this->org = $org;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->accounts as $account) {
        	$acc = new Account();
        	$acc->name = $account['name'];
        	$acc->code = $account['code'];
        	$acc->org_id = $this->org->id;
        	$acc->description = $account['description'];

        	$type = AccountType::where('name','=', $account['type'])->first();
        	$acc->account_type_id = $type->id;
        	$acc->active = true;
        	$acc->is_system = $account['is_system'];

        	$acc->save();
        }
    }
}

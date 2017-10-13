<?php

use Illuminate\Database\Seeder;
use App\Models\OrgRole;
use App\Models\Org;

class OrgUserRoleTableSeeder extends Seeder
{
	protected $org;

	protected $roles = [
		[
			'name' => 'adviser',
			'description' => 'Full control of organization',
			'permissions' => [
				'invoices' => 1,
				'contacts' => 1,
				'settings' => 1,
				'reports' => 1,
				'payroll' => 1,
				'items' => 1
			]
		],
		[
			'name' => 'invoice_only',
			'description' => 'Invoice only users can raise invoices or enter bills',
			'permissions' => [
				'invoices' => [
					'draft' => 1,
					'authorize' => 0,
					'void' => 0,
					'send' => 0,
					'edit' => 1,
					'view' => 1,
					'pdf' => 0,
					'org.view' => 0,
					'org.edit' => 0
				],
				'contacts' => [
					'view' => 1,
					'create' => 1,
					'edit' => 1,
					'delete' => 0,
					'org.view' => 1,
					'org.edit' => 0
				],
				'settings' => [
					'users' => 0,
					'tax_rates' => 0,
					'accounts' => 0,
					'bank_accounts' => 0,
					'invoices' => 0
				],
				'reports' => 0,
				'items' => [
					'view' => 1
				],
				'payroll' => 0
			]
		],
		[
			'name' => 'read_only',
			'description' => 'Read only access to organization information',
			'permissions' => [
				'invoices' => [
					'org.view' => 1,
				],
				'contacts' => [
					'org.view' => 1
				],
				'settings' => 0,
				'reports' => [
					'org.view' => 1
				],
				'items' => [
					'org.view'
				],
				'payroll' => 0,
				'employees' => [
					'org.view' => 1
				]
			]
		]
	];

	public function __construct()
	{
	}
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
        	$orgRole = OrgRole::create($role);
        }
    }
}

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
			'short_description' => 'Full control of organization',
			'description' => 'The Adviser user role has full control of the organization. They can create, authorize, delete and send biils and invoices, manage accounts, items, contacts, employees, and payroll as well as see reports.',
			'permissions' => [
				'invoices' => [
					'draft' => 1,
					'authorize' => 1,
					'void' => 1,
					'send' => 1,
					'edit' => 1,
					'view' => 1,
					'delete' => 1,
					'pdf' => 1,
					'org_view' => 1,
					'org_edit' => 1
				],
				'contacts' => [
					'view' => 1,
					'create' => 1,
					'edit' => 1,
					'delete' => 1,
					'org_view' => 1,
					'org_edit' => 1
				],
				'settings' => [
					'users' => 1,
					'tax_rates' => 1,
					'accounts' => 1,
					'bank_accounts' => 1,
					'invoices' => 1
				],
				'employees' => [
					'create' => 1,
					'view' => 1,
					'edit' => 1,
					'delete' => 1
				],
				'reports' => 1,
				'payroll' => 1,
				'items' => [
					'create' => 1,
					'view' => 1,
					'edit' => 1,
					'delete' => 1
				]
			]
		],
		[
			'name' => 'invoice only',
			'short_description' => 'Invoice only users can raise invoices or enter bills',
			'description' => 'The Invoice Only user role is limited, and suitable for someone who needs to raise invoices or enter bills, but who doesn\'t need access to accounts or reports.',
			'permissions' => [
				'invoices' => [
					'draft' => 1,
					'authorize' => 0,
					'void' => 0,
					'send' => 0,
					'edit' => 1,
					'view' => 1,
					'delete' => 0,
					'pdf' => 0,
					'org_view' => 0,
					'org_edit' => 0
				],
				'contacts' => [
					'view' => 1,
					'create' => 1,
					'edit' => 1,
					'delete' => 0,
					'org_view' => 0,
					'org_edit' => 0
				],
				'settings' => [
					'users' => 0,
					'tax_rates' => 0,
					'accounts' => 0,
					'bank_accounts' => 0,
					'invoices' => 0
				],
				'employees' => [
					'create' => 0,
					'view' => 0,
					'edit' => 0,
					'delete' => 0
				],
				'reports' => 0,
				'payroll' => 0,
				'items' => [
					'create' => 0,
					'view' => 1,
					'edit' => 0,
					'delete' => 0
				]
			]
		],
        [
            'name' => 'payroll admin',
            'short_description' => 'Payroll administration and employee management',
            'description' => 'The payroll admin user role is limited, and suitable for someone who needs to only access employee records and manage payroll.',
            'permissions' => [
                'invoices' => [
                    'draft' => 0,
                    'authorize' => 0,
                    'void' => 0,
                    'send' => 0,
                    'edit' => 0,
                    'view' => 0,
                    'delete' => 0,
                    'pdf' => 0,
                    'org_view' => 0,
                    'org_edit' => 0
                ],
                'contacts' => [
                    'view' => 0,
                    'create' => 0,
                    'edit' => 0,
                    'delete' => 0,
                    'org_view' => 0,
                    'org_edit' => 0
                ],
                'settings' => [
                    'users' => 0,
                    'tax_rates' => 0,
                    'accounts' => 0,
                    'bank_accounts' => 0,
                    'invoices' => 0
                ],
                'employees' => [
                    'create' => 1,
                    'view' => 1,
                    'edit' => 1,
                    'delete' => 1
                ],
                'reports' => 0,
                'payroll' => 1,
                'items' => [
                    'create' => 0,
                    'view' => 0,
                    'edit' => 0,
                    'delete' => 0
                ]
            ]
        ],
		[
			'name' => 'read only',
			'short_description' => 'Read only access to organization information',
			'description' => 'Users with the Read Only role have access to viewing most areas of Bridge Books but cannot edit or add any information. This role is suitable for anybody who needs to view information but doesn\'t need to input or edit anything.',
			'permissions' => [
				'invoices' => [
					'draft' => 0,
					'authorize' => 0,
					'void' => 0,
					'send' => 0,
					'edit' => 0,
					'view' => 1,
					'delete' => 0,
					'pdf' => 0,
					'org_view' => 1,
					'org_edit' => 0
				],
				'contacts' => [
					'view' => 0,
					'create' => 0,
					'edit' => 0,
					'delete' => 0,
					'org_view' => 1,
					'org_edit' => 0
				],
				'settings' => [
					'users' => 0,
					'tax_rates' => 0,
					'accounts' => 0,
					'bank_accounts' => 0,
					'invoices' => 0
				],
				'employees' => [
					'create' => 0,
					'view' => 1,
					'edit' => 0,
					'delete' => 0
				],
				'reports' => 1,
				'payroll' => 0,
				'items' => [
					'create' => 0,
					'view' => 1,
					'edit' => 0,
					'delete' => 0
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

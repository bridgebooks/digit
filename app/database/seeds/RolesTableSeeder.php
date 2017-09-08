<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
	private $roles = [
		[
			'name' => 'org_admin',
			'permissions' => [
				'admin' => 1
			]
		],
		[
			'name' => 'org_member',
			'permissions' => [
				'admin' => 0
			]
		]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->roles as $role) {
        	$model = new Role();

        	$model->name = $role['name'];
        	$model->permissions = $role['permissions'];

        	$model->save();
        }
    }
}

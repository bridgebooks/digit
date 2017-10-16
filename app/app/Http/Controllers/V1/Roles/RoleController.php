<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateRole;
use App\Repositories\RoleRepository;
use App\Repositories\OrgRoleRepository;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $orgRoleRepository;

    public function __construct(RoleRepository $roleRepository, OrgRoleRepository $orgRoleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->orgRoleRepository = $orgRoleRepository;
    }

    public function index()
    {
        return $this->roleRepository->all();
    }

    public function org() 
    {
        return $this->orgRoleRepository->all();
    }

	public function create(CreateRole $request)
	{
        $role = $this->roleRepository->create($request->all());

        return response()->json($role);
	}
}

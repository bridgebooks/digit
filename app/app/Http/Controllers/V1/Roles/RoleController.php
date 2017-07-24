<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateRole;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index() {

        return $this->roleRepository->all();
    }

	public function create(CreateRole $request)
	{
        $role = $this->roleRepository->create($request->all());

        return response()->json($role);
	}
}

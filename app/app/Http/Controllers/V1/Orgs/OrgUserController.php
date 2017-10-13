<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;

class OrgUserController extends Controller
{
	public function __construct()
	{
		$this->middleware('jwt.auth');
	}

	public function all()
	{
	}

	public function invite()
	{
	}
}
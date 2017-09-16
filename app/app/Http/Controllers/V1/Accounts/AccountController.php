<?php

namespace App\Http\Controllers\V1\Accounts;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{
	use UserRequest, Pageable;

	protected $repository;

	public function __construct(AccountRepository $repository) {
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function index()
	{	
	}
}
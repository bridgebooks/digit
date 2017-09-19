<?php

namespace App\Http\Controllers\V1\Accounts;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\AccountRepository;
use App\Http\Requests\V1\CreateAccount;
use App\Http\Requests\V1\UpdateAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{
	use UserRequest, Pageable;

	protected $repository;

	public function __construct(AccountRepository $repository) {
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function create(CreateAccount $request)
	{	
		$this->authorize('create', \App\Models\Account::class);

		$attrs = $request->all();

		$account = $this->repository->create($attrs);

		return $account;
	}

	public function get(string $id)
	{
		return $this->repository->find($id);
	}

	public function update(UpdateAccount $request, string $id)
	{
		$account = \App\Models\Account::find($id);

		$this->authorize('update', $account);

		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}

	public function delete(string $id)
	{
		$account = \App\Models\Account::find($id);

		$this->authorize('delete', $account);

		$this->repository->delete($id);	

		return response()->json([
			'status' => 'success',
			'message' => 'Account successfully deleted'
		]);
	}
}
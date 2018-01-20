<?php

namespace App\Http\Controllers\V1\Accounts;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\AccountRepository;
use App\Http\Requests\V1\CreateAccount;
use App\Http\Requests\V1\UpdateAccount;
use App\Http\Requests\V1\BulkDeleteAccounts;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountController extends Controller
{
	use UserRequest, Pageable;

	protected $repository;

	public function __construct(AccountRepository $repository) {
		$this->middleware('jwt.auth');
        $this->middleware('subscription.check');
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

	public function types()
	{
		$types = AccountType::with('children')->where('parent_id', NULL)->get();
		$transformed = [];

		foreach ($types as $type) {
			$t = [
				'name' => $type->name,
				'children' => []
			];

			foreach ($type->children as $child) {
				$t['children'][] = [
					'id' => $child->id,
					'name' => $child->name
				];
			}

			$transformed[] = $t;
		}

		return response()->json(['data' => $transformed]);
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

	public function bulkDelete(BulkDeleteAccounts $request)
    {
        $ids = $request->get('accounts');

        $accounts = $this->repository->skipPresenter()->findWhereIn('id', $ids);

        $this->authorize('bulk', \App\Models\Account::class);

        $this->repository->deleteMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully deleted'
        ]);
    }
}
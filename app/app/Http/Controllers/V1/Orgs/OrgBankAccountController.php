<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Http\Requests\V1\NewOrgBankAccount;
use App\Http\Requests\V1\UpdateOrgBankAccount;
use App\Traits\UserRequest;
use App\Repositories\OrgBankAccountRepository;
use Illuminate\Http\Request;

class OrgBankAccountController extends Controller
{
	use Pageable, UserRequest;

	protected $repository;

	public function __construct(OrgBankAccountRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function index(Request $request, string $id)
	{
		//models per page
        $perPage = $request->input('perPage', 30);
        //current page
        $page = $request->input('page', 1);

        $items = $this->repository->scopeQuery(function ($query) use ($id) {
        	return $query->where('org_id', $id);
        })->all();

        return $this->paginate($items['data'], $perPage, []);
	}

	public function create(NewOrgBankAccount $request)
	{
		$this->authorize('create', \App\Models\OrgBankAccount::class);

		$attrs = $request->all();

		$attrs['user_id'] = $this->requestUser()->id;

		return $this->repository->create($attrs);
	}

	public function update(UpdateOrgBankAccount $request, string $org_id, string $id)
	{
		$account = $this->repository->skipPresenter()->find($id);

		$this->authorize('update', $acount);

		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}

	public function delete(Request $request, string $org_id, string $id)
	{
		$account = $this->repository->skipPresenter()->find($id);

		$this->authorize('delete', $account);

		$this->repository->delete($id);

		return response()->json([
			'status' => 'success',
			'message' => 'Model deleted successfully'
		]);
	}
}
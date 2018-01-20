<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\SalePurchaseItemRepository;
use App\Http\Requests\V1\GetOrgItems;

class OrgItemsController extends Controller
{
	use Pageable, UserRequest;

	protected $repository;

	public function __construct(SalePurchaseItemRepository $repository)
	{
		$this->middleware('jwt.auth');
        $this->middleware('subscription.check');
		$this->repository = $repository;
	}

	public function all(GetOrgItems $request, string $id)
	{
		//models per page
        $perPage = $request->input('perPage', 30);
        //current page
        $page = $request->input('page', 1);

        $items = $this->repository->skipCache()->findWhere([
            'org_id' => $id,
            'deleted_at' => null
        ]);

        return $this->paginate($items['data'], $perPage, []);
	}
}
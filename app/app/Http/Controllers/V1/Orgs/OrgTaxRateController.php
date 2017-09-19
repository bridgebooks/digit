<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\TaxRateRepository;
use Illuminate\Http\Request;

class OrgTaxRateController extends Controller
{
	use Pageable, UserRequest;

	protected $repository;

	public function __construct(TaxRateRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function all(Request $request, string $id)
	{
		//models per page
        $perPage = $request->input('perPage', 30);
        //current page
        $page = $request->input('page', 1);

        $items = $this->repository->skipCache()->scopeQuery(function ($query) use ($id) {
        	return $query
        		->where('org_id', $id)
        		->orWhere('org_id', NULL);
        })->all();

        return $this->paginate($items['data'], $perPage, []);
	}
}
<?php

namespace App\Http\Controllers\V1\Orgs;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Controller;
use App\Http\Controllers\Traits\Pageable;
use App\Traits\UserRequest;
use App\Repositories\InvoiceRepository;

class OrgInvoiceController extends Controller
{
	use Pageable, UserRequest;

	protected $repository;

	public function __construct(InvoiceRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function all(Request $request, string $id)
	{
		// models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // model type
        $type = $request->input('type', 'acc_rec'); 

        $items = $this->repository->findWhere([
            'org_id' => $id,
            'type' => $type
        ]);

        return $this->paginate($items['data'], $perPage, []);
	}
}
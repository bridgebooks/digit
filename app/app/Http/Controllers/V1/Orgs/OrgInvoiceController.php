<?php

namespace App\Http\Controllers\V1\Orgs;

use Carbon\Carbon;
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

	public function invoiceEvents(Request $request, string $id)
	{
        $items = $this->repository->scopeQuery(function ($query) use($request, $id) {
            // start date
            $start = $request->input('start_date');
            // end date
            $end = $request->input('end_date');

            $fromDate = new Carbon($start);
            $toDate = new Carbon($end);

	        return $query->where('org_id', $id)
	        	->whereIn('status', ['submitted', 'authorized', 'sent'])
	        	->whereBetween('created_at', [$fromDate->toDateTimeString(), $toDate->toDateTimeString()]);
        	})->all();

        return $items;
	}

	public function invoices(Request $request, string $id)
	{
		// models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // status
        $status = $request->input('status', 'all');
        // type
        $type = $request->input('type', 'acc_rec');

        if ($this->can('invoices.org_view'))
        	$items = $this->repository->with(['contact'])->org($id, $type, $status);
        else
        	$items = $this->repository->with(['contact'])->user($this->requestUser()->id, $id, $type, $status);

        return $this->paginate($items['data'], $perPage, []);
	}
}
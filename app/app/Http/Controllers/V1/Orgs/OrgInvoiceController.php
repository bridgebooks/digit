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
        	 // period
	        $period = $request->input('period', 'month');
	        // now date
	        $now = new Carbon('now');
	
	        if ($period == 'month') {
	        	$fromDate = $now->copy()->startOfMonth();
	        	$toDate = $now->copy()->endOfMonth();
	        } elseif ($period == 'week') {
	        	$fromDate = $now->copy()->startOfWeek();
	        	$toDate = $now->copy()->endOfWeek();
	        }

	        return $query->where('org_id', $id)
	        	->whereIn('status', ['submitted', 'authorized', 'sent'])
	        	->whereBetween('created_at', [$fromDate->toDateTimeString(), $toDate->toDateTimeString()]);
        	})->all();

        return $items;
	}

	public function sales(Request $request, string $id)
	{
		// models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // status
        $status = $request->input('status');

        $items = $this->repository->with(['contact'])->org($id, 'acc_rec', $status);

        return $this->paginate($items['data'], $perPage, []);
	}

	public function bills(Request $request, string $id)
	{
		// models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // status
        $status = $request->input('status');

        $items = $this->repository->with(['contact'])->org($id, 'acc_pay', $status);

        return $this->paginate($items['data'], $perPage, []);
	}
}
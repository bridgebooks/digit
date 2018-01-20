<?php

namespace App\Http\Controllers\V1\Invoices;

use Illuminate\Http\Request;
use App\Traits\UserRequest;
use App\Repositories\InvoiceLineItemRepository;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\UpdateLineItem;

class InvoiceItemController extends Controller
{
	protected $repository;

	public function __construct(InvoiceLineItemRepository $repository)
	{
		$this->middleware('jwt.auth');
        $this->middleware('subscription.check');
		$this->repository = $repository;
	}

	public function update(UpdateLineItem $request, string $id)
	{
		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}

	public function delete(string $id)
	{
		return $this->repository->delete($id);
	}
}
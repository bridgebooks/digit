<?php

namespace App\Http\Controllers\V1\Invoices;

use App\Jobs\GenerateInvoicePDF;
use App\Jobs\SendInvoiceEmail;
use Illuminate\Http\Request;
use App\Traits\UserRequest;
use App\Repositories\InvoiceRepository;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateInvoice;
use App\Http\Requests\V1\UpdateInvoice;
use App\Http\Requests\V1\SendInvoice;

class InvoiceController extends Controller
{
	use UserRequest;

	protected $repository;

	public function __construct(InvoiceRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function create(CreateInvoice $request)
	{
		$this->authorize('create', \App\Models\Invoice::class);

		$attrs = $request->only([
			'org_id', 
			'type', 
			'contact_id', 
			'due_at', 
			'raised_at', 
			'invoice_no', 
			'reference', 
			'line_amount_type',
			'sub_total',
			'tax_total',
			'total',
			'status',
		]);

		$attrs['user_id'] = $this->requestUser()->id;

		$invoice = $this->repository->skipPresenter()->create($attrs);

		$items = $request->get('items');

		$lineItems = [];

		foreach ($items as $item) {
			$lineItems[] = [
				'row_order' => $item['row_order'],
				'item_id' => $item['item_id'],
				'description' => $item['description'],
				'quantity' => $item['quantity'],
				'unit_price' => (float) $item['unit_price'],
				'discount_rate' => (float) $item['discount'],
				'account_id' => $item['account_id'],
				'tax_rate_id' => $item['tax_rate_id'],
				'amount' => $item['amount'],
			];
		}

		$invoice->items()->createMany($lineItems);

		return $this->repository->skipPresenter(false)->find($invoice->id);
	}

	public function send(SendInvoice $request, string $id)
	{
		$invoice = $this->repository->skipPresenter()->find($id);

		$this->authorize('send', $invoice);

		$params = $request->only(['to','message','subject','send_copy', 'attach_pdf', 'mark_sent']);

		if ($params['mark_sent']) $this->repository->update(['status' => 'sent'], $id);

		GenerateInvoicePDF::dispatch($invoice)->chain([
			new SendInvoiceEmail($invoice, $params)
		]);

		return response()->json([
			'status' => 'success',
			'message' => 'Invoice will be sent shortly'
		]);
	}

	public function download(string $id)
	{
		$invoice = $this->repository->skipPresenter()->find($id);

		$this->authorize('send', $invoice);

		return response()->json([
			'data' => [
				'url' => $invoice->pdf_url
			]
		]);
	}

	public function get(string $id)
	{
		return $this->repository->find($id);
	}

	public function update(UpdateInvoice $request, string $id)
	{
		$invoice = $this->repository->skipPresenter()->find($id);

		$this->authorize('update', $invoice);

		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}
}
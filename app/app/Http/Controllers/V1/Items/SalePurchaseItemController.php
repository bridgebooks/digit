<?php

namespace App\Http\Controllers\V1\Items;

use App\Http\Controllers\V1\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Pageable;
use App\Repositories\SalePurchaseItemRepository;
use App\Traits\UserRequest;
use App\Http\Requests\V1\CreateSalePurchaseItem;


class SalePurchaseItemController extends Controller
{
	use Pageable, UserRequest;

	protected $repository;

	public function __construct(SalePurchaseItemRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function create(CreateSalePurchaseItem $request)
	{
		$attrs = $request->all();
		$attrs['user_id'] = $this->requestUser()->id;

		$item = $this->repository->create($attrs);

		return $item;
	}

	public function update(Request $request, string $id)
	{
		$item = \App\Models\SalePurchaseItem::find($id);

		$this->authorize('update', $item);

		return $this->repository->update($request->all(), $id);
	}

	public function get(string $id)
	{
		return $this->repository->find($id);
	}

	public function delete(string $id)
	{
		$item = \App\Models\SalePurchaseItem::find($id);

		$this->authorize('delete', $item);

		$this->repository->delete($id);

		return response()->json([
			'status' => 'success',
			'message' => 'Item successfully deleted'
		]);
	}
}
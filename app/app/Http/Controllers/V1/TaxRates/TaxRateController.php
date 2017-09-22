<?php

namespace App\Http\Controllers\V1\TaxRates;

use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\TaxRateRepository;
use App\Http\Requests\V1\CreateTaxRate;
use App\Http\Requests\V1\UpdateTaxRate;
use App\Http\Requests\V1\BulkDeleteTaxRates;

class TaxRateController extends Controller
{
	use Pageable;

	protected $repository;

	public function __construct(TaxRateRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function create(CreateTaxRate $request)
	{
		$this->authorize('create', \App\Models\TaxRate::class);

		$attrs = $request->only(['name', 'org_id', 'is_system']);

		$rate = $this->repository->skipPresenter()->create($attrs);

		if ($request->get('components')) {
			$components = [];

			foreach ($request->get('components') as $component) {
				$components[] = [
					'name' => $component['name'],
					'tax_rate_id' => $rate->id,
					'value' => $component['value'],
					'compound' => $component['compound'] || false
				];
			}

			$rate->components()->createMany($components);
		}

		return $this->repository->skipPresenter(false)->find($rate->id);
	}

	public function get(string $id)
	{
		return $this->repository->find($id);
	}

	public function update(UpdateTaxRate $request, string $id)
	{
		$rate = \App\Models\TaxRate::find($id);

		$this->authorize('update', $rate);

		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}

	public function delete(string $id)
	{
		$rate = \App\Models\TaxRate::find($id);

		$this->authorize('delete', $account);

		$this->repository->delete($id);	

		return response()->json([
			'status' => 'success',
			'message' => 'Tax Rate successfully deleted'
		]);
	}

	public function bulkDelete(BulkDeleteTaxRates $request)
    {
        $ids = $request->get('rates');

        $accounts = $this->repository->skipPresenter()->findWhereIn('id', $ids);

        $this->authorize('bulk', \App\Models\TaxRate::class);

        $this->repository->deleteMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully deleted'
        ]);
    }
}
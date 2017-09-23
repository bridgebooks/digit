<?php

namespace App\Http\Controllers\V1\TaxRates;

use App\Http\Controllers\V1\Controller;
use App\Repositories\TaxRateComponentRepository;
use App\Http\Requests\V1\UpdateTaxRateComponent;

class TaxRateComponentController extends Controller
{
	protected $repository;

	public function __construct(TaxRateComponentRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function update(UpdateTaxRateComponent $request, string $id)
	{
		/*
		$component = \App\Models\TaxRateComponent::find($id);

		$this->authorize('update', $component);*/

		$attrs = $request->all();

		return $this->repository->update($attrs, $id);
	}
}
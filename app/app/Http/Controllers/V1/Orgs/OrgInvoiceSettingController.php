<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\UpdateInvoiceSetting;
use App\Traits\UserRequest;
use App\Repositories\OrgInvoiceSettingRepository;

class OrgInvoiceSettingController extends Controller
{
	protected $repository;

	public function __construct(OrgInvoiceSettingRepository $repository)
	{
		$this->middleware('jwt.auth');
		$this->repository = $repository;
	}

	public function get(string $id)
	{
		return $this->repository->byOrgID($id);
	}

	public function update(UpdateInvoiceSetting $request, string $id)
	{
		$settings = $this->repository->skipPresenter(true)->byOrgID($id);

		$this->authorize('update', $settings);

		$attrs = $request->all();

		return $this->repository->skipPresenter(false)->update($attrs, $settings->id);	
	}
}
<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\UpdatePayrunSetting;
use App\Repositories\OrgAccountSettingRepository;

class OrgAccountSettingController extends Controller
{
    protected $repository;

    public function __construct(OrgAccountSettingRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('subscription.check');
        $this->repository = $repository;
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(string $id)
    {
        return $this->repository->byOrgID($id);
    }

    /**
     * @param string $id
     */
    public function update(UpdatePayrunSetting $request, string $id)
    {

        $settings = $this->repository->skipPresenter(true)->byOrgID($id);

        $this->authorize('view', $settings);

        $attrs = $request->only(['values']);

        array_merge((array) $settings->values, $attrs);

        return $this->repository->skipPresenter(false)->update($attrs, $settings->id);
    }
}
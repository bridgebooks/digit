<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\UpdatePayrunSetting;
use App\Repositories\OrgPayrunSettingRepository;

class OrgPayrunSettingController extends Controller
{
    protected $repository;

    public function __construct(OrgPayrunSettingRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->repository = $repository;
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(string $id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param string $id
     */
    public function update(UpdatePayrunSetting $request, string $id)
    {

        $settings = $this->repository->skipPresenter(true)->get($id);

        $this->authorize('view', $settings);

        $attrs = $request->only(['values']);

        array_merge((array) $settings->values, $attrs);

        return $this->repository->skipPresenter(false)->update($attrs, $settings->id);
    }
}
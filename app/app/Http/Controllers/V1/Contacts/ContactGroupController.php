<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\V1\Controller;
use App\Repositories\ContactGroupRepository;
use Illuminate\Http\Request;

class ContactGroupController extends Controller
{
    protected $repository;

    public function __construct(ContactGroupRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function update(Request $request, string $id)
    {
        $group = $this->repository->skipPresenter()->find($id);

        $this->authorize('update', $group);

        $attributes = $request->only(['name', 'description']);

        return $this->repository->update($attributes, $id);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $group = $this->repository->skipCache()->skipPresenter()->find($id);

        $this->authorize('delete', $group);

        $this->repository->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact group deleted'
        ], 200);
    }
}
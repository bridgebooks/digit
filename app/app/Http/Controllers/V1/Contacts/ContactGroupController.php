<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\V1\Controller;
use App\Repositories\ContactGroupRepository;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactGroupController extends Controller
{
    protected $repository;
    protected $contactRepository;

    public function __construct(ContactGroupRepository $repository, ContactRepository $contactRepository)
    {
        $this->middleware('jwt.auth');
        $this->repository = $repository;
        $this->contactRepository = $contactRepository;
    }

    public function addMany(Request $request, string $id)
    {
        $ids = $request->get('contacts');

        $contacts = $this->contactRepository->skipPresenter()->findWhereIn('id', $ids);

        $this->authorize('create', \App\Models\Contact::class);

        $this->repository->toGroup($id, $contacts);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully added to group'
        ]);
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
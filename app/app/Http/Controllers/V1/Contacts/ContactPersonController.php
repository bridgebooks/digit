<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateContactPerson;
use App\Http\Requests\V1\UpdateContactPerson;
use App\Repositories\ContactPersonRepository;

class ContactPersonController extends Controller
{
    protected $repository;

    public function __construct(ContactPersonRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->repository = $repository;
    }

    /**
     * @param CreateContactPerson $request
     * @return mixed
     */
    public function create(CreateContactPerson $request)
    {
        $attributes = $request->only([
            'contact_id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'email',
            'role',
            'is_primary_contact'
        ]);

        return $this->repository->create($attributes);
    }

    public function update(UpdateContactPerson $request, string $id)
    {
        $person = $this->repository->skipPresenter()->find($id);

        $this->authorize('update', $person);

        return $this->repository->skipPresenter(false)->update($request->all(), $id);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $person = $this->repository->skipCache()->skipPresenter(true)->find($id);

        $this->authorize('delete', $person);

        $this->repository->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'contact person deleted'
        ]);
    }
}
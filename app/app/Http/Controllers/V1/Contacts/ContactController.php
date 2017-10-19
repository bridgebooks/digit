<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateContact;
use App\Http\Requests\V1\GetContact;
use App\Http\Requests\V1\UpdateContact;
use App\Http\Requests\V1\BulkDeleteContacts;
use App\Repositories\ContactPersonRepository;
use App\Repositories\ContactRepository;
use App\Traits\UserRequest;

class ContactController extends Controller
{
    use UserRequest;

    protected $contactRepository;
    protected $contactPersonRepository;

    protected $attributes = [
        'org_id',
        'user_id',
        'contact_group_id',
        'type',
        'name',
        'phone',
        'email',
        'website',
        'address_line_1',
        'address_line_2',
        'city_town',
        'state_region',
        'postal_zip',
        'country',
        'bank_id',
        'bank_account_name',
        'bank_account_no'
    ];

	public function __construct(ContactRepository $contactRepository, ContactPersonRepository $contactPersonRepository)
	{
        $this->middleware('jwt.auth');
        $this->contactRepository = $contactRepository;
        $this->contactPersonRepository = $contactPersonRepository;
	}

    /**
     * @param CreateContact $request
     * @return mixed
     */
    public function create(CreateContact $request)
    {
        $this->authorize('create', \App\Models\Contact::class);

        $attributes = $request->only($this->attributes);

        $attributes['user_id'] = $this->requestUser()->id;

        $contact = $this->contactRepository->create($attributes);

        return $contact;
    }

    /**
     * @param GetContact $request
     * @param string $id
     * @return mixed
     */
    public function one(GetContact $request, string $id)
    {
        return $this->contactRepository->find($id);
    }

    public function people(string $id)
    {
        $contact = $this->contactRepository->skipPresenter()->find($id);

        $this->authorize('view', $contact);

        return $this->contactPersonRepository->findWhere(['contact_id' => $id ]);
    }

    /**
     * @param UpdateContact $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdateContact $request, string $id)
    {
        $contact = \App\Models\Contact::find($id);

        $this->authorize('update', $contact);

        return $this->contactRepository->update($request->all(), $id);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $contact = \App\Models\Contact::find($id);

        $this->authorize('delete', $contact);

        $this->contactRepository->skipPresenter(false)->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact deleted'
        ]);
    }

    public function bulkDelete(BulkDeleteContacts $request)
    {
        $ids = $request->get('contacts');

        $contacts = $this->contactRepository->skipPresenter()->findWhereIn('id', $ids);

        $this->authorize('bulk', \App\Models\Contact::class);

        $this->contactRepository->deleteMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully deleted'
        ]);
    }
}
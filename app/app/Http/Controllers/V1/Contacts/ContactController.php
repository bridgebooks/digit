<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateContact;
use App\Repositories\ContactRepository;
use App\Traits\UserRequest;

class ContactController extends Controller
{
    use UserRequest;

    protected $contactRepository;

    protected $attributes = [
        'org_id',
        'user_id',
        'contact_group_id',
        'type',
        'name',
        'phone',
        'website',
        'address_line_1',
        'address_line_2',
        'city_town',
        'state_region',
        'postal_zip',
        'country',
    ];

	public function __construct(ContactRepository $contactRepository)
	{
        $this->middleware('jwt.auth');
        $this->contactRepository = $contactRepository;
	}

	public function create(CreateContact $request)
    {
        $attributes = $request->only($this->attributes);

        $attributes['user_id'] = $this->requestUser()->id;

        $contact = $this->contactRepository->create($attributes);

        return $contact;
    }
}
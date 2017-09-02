<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Contacts\ContactGroupController;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\GetOrgContacts;
use App\Http\Requests\V1\CreateContactGroup;
use App\Models\ContactGroup;
use App\Repositories\ContactPersonRepository;
use App\Repositories\ContactGroupRepository;
use App\Repositories\ContactRepository;
use App\Repositories\OrgRepository;
use App\Traits\UserRequest;

class OrgContactsController extends Controller
{
    use Pageable, UserRequest;

    protected $orgRepository;
    protected $contactRepository;
    protected $contactGroupRepository;
    protected $contactPersonRepository;

    /**
     * OrgContactsController constructor.
     * @param OrgRepository $orgRepository
     * @param ContactRepository $contactRepository
     * @param ContactGroupRepository $contactGroupRepository
     * @param ContactPersonRepository $contactPersonRepository
     */
    public function __construct(
        OrgRepository $orgRepository,
        ContactRepository $contactRepository,
        ContactGroupRepository $contactGroupRepository,
        ContactPersonRepository $contactPersonRepository)
    {
        $this->middleware('jwt.auth');
        $this->orgRepository = $orgRepository;
        $this->contactRepository = $contactRepository;
        $this->contactGroupRepository = $contactGroupRepository;
        $this->contactPersonRepository = $contactPersonRepository;
    }

    /**
     * @param GetOrgContacts $request
     * @param string $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function contacts(GetOrgContacts $request, string $id)
    {
        //models per page
        $perPage = $request->input('perPage', 30);
        //current page
        $page = $request->input('page', 1);
        //contact type
        $type = $request->input('type', 'customer');

        $contacts = $this->contactRepository->skipCache()->findWhere([
            'org_id' => $id,
            'type' => $type,
            'deleted_at' => null
        ]);

        return $this->paginate($contacts['data'], $perPage, []);
    }

    public function contactGroups(string $id)
    {
        $this->authorize('list', ContactGroup::class);

        return $this->contactGroupRepository->findWhere(['org_id' => $id ]);
    }

    public function createContactGroup(CreateContactGroup $request, string $id)
    {
        $attributes = $request->only(['name', 'description']);
        $attributes['org_id'] = $id;

        return $this->contactGroupRepository->create($attributes);
    }
}
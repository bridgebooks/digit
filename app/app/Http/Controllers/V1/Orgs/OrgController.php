<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Traits\UserRequest;
use App\Http\Requests\V1\CreateOrg;
use App\Http\Requests\V1\UpdateOrg;
use App\Repositories\OrgRepository;

class OrgController extends Controller
{
  use UserRequest;

  protected $orgRepository;

  public function __construct(OrgRepository $orgRepository) {
  	$this->middleware('jwt.auth');

    $this->orgRepository = $orgRepository;
  }

  public function index()
  {
    echo 'orgs';
  }

  public function create(CreateOrg $request)
  {
    // org attributes
    $attributes = [
      'name', 
      'business_name', 
      'description', 
      'business_reg_no', 
      'industry_id', 
      'address_line_1',
      'address_line_2', 
      'city_town', 
      'state_region', 
      'postal_zip'
    ];

    $org = $this->orgRepository->skipPresenter(true)->create($request->only($attributes));
    $org->users()->attach($this->requestUser()->id);

    return $org->presenter();
  }

  public function update(UpdateOrg $request, String $id)
  {

  }
}

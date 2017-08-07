<?php

namespace App\Http\Controllers\V1\Orgs;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\V1\Controller;
use App\Traits\UserRequest;
use App\Http\Requests\V1\CreateOrg;
use App\Http\Requests\V1\UpdateOrg;
use App\Repositories\OrgRepository;
use App\Repositories\UserRepository;

class OrgController extends Controller
{
  use UserRequest;

  protected $orgRepository;
  protected $userRepository;

  public function __construct(OrgRepository $orgRepository, UserRepository $userRepository) {

  	$this->middleware('jwt.auth');
    $this->orgRepository = $orgRepository;
    $this->userRepository = $userRepository;
  }

  private function addOrg(\App\Models\Org $org) {

    $currentOrgs = $this->getUserOrgs();
    $newOrg = [
      'id' => $org->id,
      'name' => $org->name
    ];

    array_push($currentOrgs, $newOrg);

    return $currentOrgs;
  }

  public function index()
  {
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

    // user
    $user = $this->requestUser();
    // create org
    $org = $this->orgRepository->skipPresenter()->create($request->only($attributes));
    // associate user with org
    $org->users()->attach($user->id);
    // create update token
    try {
      $customTokenClaims['acl'] = $this->getUserRoles();
      $customTokenClaims['orgs'] = $this->addOrg($org);

      $token = JWTAuth::fromUser($user, $customTokenClaims);

      return response()->json([
        'status' => 'success',
        'data' => [
          'token' => $token,
          'org' => $org
        ]
      ]);

    } catch (JWTException $e) {
        return response()->json([
          'status' => 'error',
          'message' => 'Unable to create token'
        ], 500);
    }
  }

  public function update(UpdateOrg $request, String $id)
  {

  }
}

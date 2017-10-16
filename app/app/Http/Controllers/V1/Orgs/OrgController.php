<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\V1\Controller;
use App\Events\OrgCreated;
use App\Http\Requests\V1\GetOrgContacts;
use App\Http\Requests\V1\OrgLogoUpload;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use JWTAuth;
use CloudinaryImage;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\UserRequest;
use App\Http\Controllers\Traits\Pageable;
use App\Http\Requests\V1\CreateOrg;
use App\Http\Requests\V1\UpdateOrg;
use App\Repositories\OrgRepository;
use App\Repositories\UserRepository;

class OrgController extends Controller
{
  use UserRequest, Pageable;

  protected $orgRepository;
  protected $userRepository;
  protected $contactRepository;
  protected $orgRoleRepository;

  protected $attributes = [
      'name',
      'business_name',
      'business_reg_no',
      'logo_url',
      'description',
      'business_reg_no',
      'industry_id',
      'address_line_1',
      'address_line_2',
      'city_town',
      'state_region',
      'country',
      'postal_zip',
      'phone',
      'email',
      'website'
  ];

  public function __construct(
    OrgRepository $orgRepository, 
    UserRepository $userRepository, 
    ContactRepository $contactRepository
  ) {

  	$this->middleware('jwt.auth');
    $this->orgRepository = $orgRepository;
    $this->userRepository = $userRepository;
    $this->contactRepository = $contactRepository;
  }

    private function addOrg(\App\Models\Org $org) 
    {

      $currentOrgs = $this->getUserOrgs();
      $newOrg = [
        'id' => $org->id,
        'name' => $org->name
      ];

      array_push($currentOrgs, $newOrg);

      return $currentOrgs;
    }

    private function addACL(\App\Models\OrgRole $role)
    {
      $acl = [];

      $acl[] = [
        'name' => $role->name,
        'permissions' => $role->permissions
      ];
      
      return $acl;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        //models per page
        $perPage = $request->input('perPage', 30);
        //current page
        $page = $request->input('page', 1);

        $orgs = $this->orgRepository->all();

        return $this->paginate($orgs['data'], count($orgs['data']), $page, $perPage, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);
    }

    /**
     * Fetch Org
     * @param string $id
     * @return mixed
     */
    public function one(string $id)
    {
        return $this->orgRepository->with(['industry'])->find($id);
    }

    /**
     * Create new Org
     * @param CreateOrg $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateOrg $request)
    {
      // user
      $user = $this->requestUser();
      // create org
      $org = $this->orgRepository->skipPresenter()->create($request->only($this->attributes));
      // create update token
      try {
        // get `adviser` role
        $role = \App\Models\OrgRole::where('name', 'adviser')->first();
        // create org invoice settings
        $settings = new \App\Models\OrgInvoiceSetting();
        $settings->org_id = $org->id;
        $settings->save();
        // custom jwt claims
        $customTokenClaims['roles'] = $this->getUserRoles();
        $customTokenClaims['orgs'] = $this->addOrg($org);
        $customTokenClaims['acl'] = $this->addACL($role);
        // create jwt
        $token = JWTAuth::fromUser($user, $customTokenClaims);

        // associate user with org
        $org->users()->attach($user->id, ['status' => 'active']);
        // assoicate user with org role
        $user->orgRoles()->attach($role->id, ['org_id' => $org->id]);

        //fire OrgCreated Event
        event(new OrgCreated($org));

        return response()->json([
          'status' => 'success',
          'data' => [
            'token' => $token,
            'org' => $org,
            'user' => $user
          ]
        ]);

      } catch (JWTException $e) {
          return response()->json([
            'status' => 'error',
            'message' => 'Unable to create token'
          ], 500);
      }
    }

    /**
     * @param UpdateOrg $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdateOrg $request, string $id)
    {
        $org = $this->orgRepository->update($request->all(), $id);

        return $org;
    }

    /**
     * @param OrgLogoUpload $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadLogo(OrgLogoUpload $request)
    {
      $path = $request->file('file')->store('logos', 'cloudinary');

      return response()->json(['status' => 'success', 'url' => CloudinaryImage::url($path) ]);
    }
}

<?php

namespace App\Http\Controllers\V1\Users;

use App\Events\PrimaryUserCreated;
use Notification;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\V1\Controller;
use App\Notifications\UserCreated;
use App\Http\Requests\V1\CreateUser;
use App\Http\Requests\V1\ValidateUser;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;

class CreateUserController extends Controller
{
	protected $userRepository;
	protected $roleRepository;

  	public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
  	{
  		$this->userRepository = $userRepository;
  		$this->roleRepository = $roleRepository;
 	  }

    private function getUserRoles(\App\Models\User $user)
    {
      $roles = [];

      $userRoles = $user->roles;

      foreach ($userRoles as $role) {
        $roles[] = [
          'name' => $role->name,
          'permissions' => $role->permissions
        ];
      }

      return $roles;
    }

    private function getUserACL(\App\Models\User $user)
    {
      $roles = [];

      $userRoles = $user->orgRoles;

      foreach ($userRoles as $role) {
        $roles[] = [
          'name' => $role->name,
          'permissions' => $role->permissions
        ];
      }

      return $roles;
    }

    private function getUserOrgs(\App\Models\User $user)
    {
      $orgs = [];

      $userOrgs = $user->orgs;

      foreach ($userOrgs as $org) {
        $orgs[] = [
          'id' => $org->id,
          'name' => $org->name
        ];
      }

      return $orgs;
    }

    /**
     * Create User Account
     * @param $request App\Http\Requests\V1\CreateUser
     * Form request
     * @return string JSON
     **/
  	public function create(CreateUser $request)
    {
     	$userAttributes = $request->only(['first_name', 'last_name', 'email', 'phone']);

     	$user = $this->userRepository->skipPresenter(true)->create($userAttributes);

     	if($request->input('primary_user')) {
     		// Add user to 'org_admin'
            $role = $this->roleRepository->skipPresenter(true)
              ->findWhere(['name' => 'org_admin'])
              ->first();

            $user->roles()->attach($role->id);

            // Trigger 'OnUserCreated' event
            event(new PrimaryUserCreated($user, config('app.trial_duration')));
     	} else {
        // Add user to 'org_member'
        $role = $this->roleRepository->skipPresenter(true)
          ->findWhere(['name' => 'org_member'])
          ->first();
          
        $user->roles()->attach($role->id);
      }

      // Send welcome email
      Notification::send( $user, new UserCreated($user, $user->getVerificationToken()) );

      return $user;
  	}

    /**
     * Validate User Account
     * @param $request App\Http\Requests\V1\ValidateUser
     * Form request
     * @param string $id
     * User ID
     * @return string JSON
     **/
    public function validateUser(ValidateUser $request, String $id) 
    {
      $password = $request->password;
      $token = $request->token;
      $invited = $request->get('invited', false);
      $org_id = $request->get('org', false);

      try {
        $user = $this->userRepository->skipPresenter(true)->validateUser($id, $password, $token);
        $validatedUser = $this->userRepository->skipPresenter(false)->find($id);
        // login user
        try {
          if ($invited && $org_id) {
            $user->orgs()
              ->newPivotStatementForId($org_id)
              ->update(['status' => 'active']);
          }
          
          $customTokenClaims = [
            'roles' => $this->getUserRoles($user), 
            'acl' => $this->getUserACL($user),
            'orgs' => $this->getUserOrgs($user)
          ];
          $token = JWTAuth::fromUser($user, $customTokenClaims);

          return response()->json([
            'status' => 'success',
            'data' => [
              'token' => $token,
              'user' => $validatedUser['data']
            ]
          ]);

        } catch (JWTException $e) {
          return response()->json([
            'status' => 'error',
            'message' => 'Unable to create token'
          ], 500);
        }
      } 
      catch(App\Exceptions\UserModelNotFoundException $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage() ], 404);
      }
      catch(App\Exceptions\VerificationTokenMismatch $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage() ], 400);
      }
    }
}

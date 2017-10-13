<?php

namespace App\Http\Controllers\V1\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\LoginUser;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
	public $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
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
		$acl = [];

      	$orgRoles = $user->orgRoles;

      	foreach ($orgRoles as $role) {
	        $acl[] = [
	          'name' => $role->name,
	          'permissions' => $role->permissions
	        ];
      	}

     	return $acl;
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

	public function authenticate(LoginUser $request)
	{
		$credentials = $request->only(['email', 'password']);
		if (Auth::attempt($credentials)) 
		{
			$user = Auth::user();

			if ($user->is_verified) {
                try {
                    $customTokenClaims = [
                        'orgs' => $this->getUserOrgs($user),
                        'roles' => $this->getUserRoles($user),
                        'acl' => $this->getUserACL($user)
                    ];

                    $token = JWTAuth::fromUser($user, $customTokenClaims);

                    return response()->json([
                        'status' => 'success',
                        'data' => [
                            'token' => $token,
                            'user' => $this->userRepository->find($user->id)['data']
                        ]
                    ]);

                } catch (JWTException $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unable to create token'
                    ], 500);
                }
            } else {
			    return response()->json([
			        'status' => 'error',
                    'message' => 'Account is not verified. Please click the verification link in the welcome email sent to you'
                ], 403);
            }
		} 
		else
		{
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid login credentials. Email/Password incorrect'
			], 403);
		}
	}

	public function logout()
	{
		$token = JWTAuth::getToken();

		JWTAuth::invalidate($token);

		return response()->json([
			'status' => 'success',
			'message' => 'Logout successful'
		]);
	}
}

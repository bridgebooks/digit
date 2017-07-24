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

			try {
				$customTokenClaims = [
					'orgs' => $this->getUserOrgs($user),
					'acl' => $this->getUserRoles($user)
				];

				$token = JWTAuth::fromUser($user, $customTokenClaims);

				return response()->json([
					'status' => 'success',
					'data' => [
						'token' => $token,
						'user' => $this->userRepository->find($user->id)
					]
				]);

			} catch (JWTException $e) {
				return response()->json([
					'status' => 'error',
					'message' => 'Unable to create token'
				], 500);
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
}

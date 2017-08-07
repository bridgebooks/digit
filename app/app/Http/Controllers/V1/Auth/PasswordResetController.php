<?php

namespace App\Http\Controllers\V1\Auth;

use Notification;
use Hash;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\PasswordReset;
use App\Http\Requests\V1\PasswordCreate;
use App\Repositories\UserRepository;
use App\Models\PasswordReset as UserPasswordReset;
use App\Notifications\PasswordReset as PasswordResetNotification;

class PasswordResetController extends Controller
{
	protected $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function reset(PasswordReset $request)
	{
		$user = $this->userRepository->skipPresenter()
			->findWhere(['email' => $request->email])
			->first();

		$successMessage = 'A password reset link has been emailed to you. Please follow the link in the email to reset your password';

		if ($user) {

			$reset = new UserPasswordReset();
			$resetToken = $reset->make($user->email);

			if ($resetToken) {
				// Send password reset email
				Notification::send($user, new PasswordResetNotification($user, $resetToken));

				return response()->json([
					'status' => 'success',
					'message' => $successMessage
				]);
			} else {
				return response()->json([
					'status' => 'error',
					'message' => 'An error occured. Please try again.'
				], 500);
			}
		} else {
			return response()->json([
				'status' => 'success',
				'message' => $successMessage
			]);
		}
	}

	public function create(PasswordCreate $request)
	{
		$reset = new UserPasswordReset();
		$userEmail = $reset->verifyTokenRetrieveUserIdentifier($request->token);

		if ($userEmail) {
			// Get user
			$user = $this->userRepository->skipPresenter()
				->findWhere(['email' => $userEmail ])
				->first();

			if($user) {
				// Update password
				$userUpdate = $this->userRepository->update([
					'password' => Hash::make($request->password)
				], $user->id);

				// TODO: Send password changed email
				return response()->json([
					'status' => 'success',
					'message' => 'Password reset sucessfull, you can login with your new password'
				]);
			} else {
				return response()->json([
					'status' => 'error',
					'message' => 'No valid user account found'
				], 404);
			}
		} else {
			return response()->json([
				'status' => 'error',
				'message' => 'This reset link is no longer valid. Please request another password reset'
			], 400);
		}
	}
}
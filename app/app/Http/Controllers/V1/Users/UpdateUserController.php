<?php

namespace App\Http\Controllers\V1\Users;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\UpdateUser;
use App\Http\Requests\V1\UpdateUserEmail;
use App\Repositories\UserRepository;
use App\Traits\UserRequest;

class UpdateUserController extends Controller
{
    use UserRequest;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('jwt.auth');
        $this->userRepository = $userRepository;
    }

    public function update(UpdateUser $request, String $id)
    {
        $attrs = $request->only(['first_name', 'last_name', 'phone', 'email']);

        $user = $this->userRepository->update($attrs, $id);

        return $user;
    }

    public function updateEmail(UpdateUserEmail $request)
    {
        $attrs = $request->only(['email']);

        $user = $this->userRepository->update($attrs, $this->requestUser()->id);

        return $user;
    }
}

<?php

namespace App\Http\Controllers\V1\Users;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateUser;

class CreateUserController extends Controller
{
  public function create(CreateUser $request)
  {
    dd($request->all());
  }
}

<?php

namespace App\Http\Controllers\V1\Industries;

use App\Http\Controllers\V1\Controller;
use App\Traits\UserRequest;
use App\Repositories\IndustryRepository;

class IndustryController extends Controller
{
  use UserRequest;

  protected $industryRepository;

  public function __construct(IndustryRepository $industryRepository) {
    $this->industryRepository = $industryRepository;
  }

  public function index() {
  	return $this->industryRepository->all();
  }
}

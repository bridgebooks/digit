<?php

namespace App\Http\Controllers\V1\Banks;

use App\Http\Controllers\V1\Controller;
use App\Traits\UserRequest;
use App\Repositories\BankRepository;

class BankController extends Controller
{
    use UserRequest;

    protected $bankRepository;

    public function __construct(BankRepository $bankRepository) {
        $this->bankRepository = $bankRepository;
    }

    public function index() {
        return $this->bankRepository->all();
    }
}

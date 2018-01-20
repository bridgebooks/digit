<?php

namespace App\Http\Controllers\V1\Plans;

use App\Http\Controllers\V1\Controller;
use App\Repositories\PlanRepository;

class PlanController extends Controller
{
    protected $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }
}
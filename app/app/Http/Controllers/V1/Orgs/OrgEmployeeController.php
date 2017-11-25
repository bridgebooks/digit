<?php

namespace App\Http\Controllers\V1\Orgs;


use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class OrgEmployeeController extends Controller
{
    use Pageable;

    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('acl:employees.view')->only(['all']);

        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function all(Request $request, string $id)
    {
        //models per page
        $perPage = $request->input('perPage', 30);
        //employee status
        $status = $request->get('status', 'all');

        $employees = $this->repository->org($id, $status);

        return $this->paginate($employees['data'], $perPage, []);
    }
}
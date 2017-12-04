<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\PayrunRepository;
use Illuminate\Http\Request;

class OrgPayrunController extends Controller
{
    use Pageable;

    protected $repository;

    public function __construct(PayrunRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('acl:payroll')->only(['all']);
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

        $runs = $this->repository->org($id, $status);

        return $this->paginate($runs['data'], $perPage, []);
    }
}
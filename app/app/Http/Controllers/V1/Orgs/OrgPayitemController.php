<?php

namespace App\Http\Controllers\V1\Orgs;

use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\PayItemRepository;
use Illuminate\Http\Request;

class OrgPayitemController extends Controller
{
    use Pageable;

    protected $repository;

    public function __construct(PayItemRepository $repository)
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
        // models per page
        $perPage = $request->input('perPage', 30);
        // status
        $status = $request->input('status', 'active');
        $archived = $status == 'active' ? false : true;

        $items = $this->repository->org($id, $archived);

        return $this->paginate($items['data'], $perPage, []);
    }
}
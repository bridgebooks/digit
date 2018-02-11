<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/02/2018
 * Time: 08:51
 */

namespace App\Http\Controllers\V1\Accounts;


use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    use Pageable;

    protected $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('subscription.check');

        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(Request $request, string $id)
    {
        // models per page
        $perPage = $request->input('perPage', 20);

        $items =  $this->repository->findWhere([
            'account_id' => $id
        ]);

        return $this->paginate($items['data'], $perPage, []);
    }
}
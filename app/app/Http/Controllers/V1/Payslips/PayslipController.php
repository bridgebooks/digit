<?php

namespace App\Http\Controllers\V1\Payslips;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreatePayslipItem;
use App\Http\Requests\V1\UpdatePayslipItem;
use App\Repositories\PayslipItemRepository;
use App\Repositories\PayslipRepository;

class PayslipController extends Controller
{
    protected $repository;
    protected $itemRepository;

    public function __construct(PayslipRepository $repository, PayslipItemRepository $itemRepository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('acl:payroll');

        $this->repository = $repository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function items(string $id)
    {
        return $this->itemRepository->payslip($id);
    }

    /**
     * @param CreatePayslipItem $request
     * @param string $id
     * @return mixed
     */
    public function add(CreatePayslipItem $request, string $id)
    {
        $attrs = $request->only(['pay_slip_id', 'pay_item_id', 'amount']);

        return $this->itemRepository->create($attrs);
    }

    /**
     * @param UpdatePayslipItem $request
     * @param string $id
     * @return mixed
     */
    public function updateItem(UpdatePayslipItem $request, string $id)
    {
        $attrs = $request->all();

        return $this->itemRepository->update($attrs, $id);
    }

    public function deleteItem(string $id)
    {
        $this->itemRepository->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Item successully delete'
        ]);
    }
}
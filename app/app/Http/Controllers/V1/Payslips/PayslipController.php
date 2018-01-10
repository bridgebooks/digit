<?php

namespace App\Http\Controllers\V1\Payslips;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreatePayslipItem;
use App\Http\Requests\V1\UpdatePayslipItem;
use App\Notifications\EmployeePayslip;
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

    public function get(string $id)
    {
        return $this->repository->find($id);
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

    public function send(string $id)
    {
        $slip = $this->repository->skipPresenter()->with(['payrun', 'payrun.org', 'employee'])->find($id);

        if ($slip->employee->email) {
            $slip->employee->notify(new EmployeePayslip($slip));

            return response()->json([
                'status' => 'success',
                'message' => 'Payslip will be sent to employee shortly'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No email address is set for employee'
            ], 400);
        }
    }
}
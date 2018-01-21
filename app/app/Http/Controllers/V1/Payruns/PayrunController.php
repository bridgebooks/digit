<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/11/2017
 * Time: 23:31
 */

namespace App\Http\Controllers\V1\Payruns;

use App\Events\PayrunApproved;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\ApprovePayrun;
use App\Http\Requests\V1\CreatePayrun;
use App\Jobs\SendPayrunSlips;
use App\Models\Enums\PayrunStatus;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrunRepository;
use App\Traits\UserRequest;

class PayrunController extends Controller
{
    use UserRequest;

    protected $repository;
    protected $employeeRepository;

    public function __construct(PayrunRepository $repository, EmployeeRepository $employeeRepository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('subscription.check');
        $this->middleware('acl:payroll')->only(['create', 'read', 'update', 'approve']);
        $this->middleware('subscription.feature_usage_check:payruns')->only(['create']);
        $this->repository = $repository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param CreatePayrun $request
     * @return mixed
     */
    public function create(CreatePayrun $request)
    {
        $attrs = $request->all();
        $attrs['user_id'] = $this->requestUser()->id;

        $payrun = $this->repository->create($attrs);
        // get active org employees
        $employees = $this->employeeRepository->org($attrs['org_id'], 'active');
        // pay slips
        $payslips = [];

        if (count($employees) > 0) {
            foreach ($employees['data'] as $employee) {
                $payslips[] = [
                    'pay_run_id' => $payrun['data']['id'],
                    'employee_id' => $employee['id']
                ];
            }
            $this->repository->addPaySlips($payslips, $payrun['data']['id']);
        }

        return $payrun;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id)
    {
        return $this->repository->find($id);
    }

    public function update(string $id)
    {

    }

    /**
     * @param ApprovePayrun $request
     * @param string $id
     * @return mixed
     */
    public function approve(ApprovePayrun $request, string $id)
    {
        $attrs = $request->only(['notes']);

        $attrs['status'] = PayrunStatus::APPROVED;

        $payrun = $this->repository->skipPresenter(true)->find($id);

        event(new PayrunApproved($payrun));

        return $this->repository->skipPresenter(false)->update($attrs, $id);
    }

    public function send(string $id)
    {
        $payrun = $this->repository->skipPresenter(true)->with([
            'org',
            'payslips',
            'payslips.employee'
        ])->find($id);

        dispatch(new SendPayrunSlips($payrun));

        return response()->json([
            'status' => 'success',
            'message' => 'Payslips will be sent shortly.'
        ]);
    }
}
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Payslip;

/**
 * Class PayslipTransformer
 * @package namespace App\Transformers;
 */
class PayslipTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['employee', 'payrun', 'items'];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = ['employee'];


    /**
     * @param Payslip $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeEmployee(Payslip $model)
    {
        $employee = $model->employee;

        return $this->item($employee, new EmployeeTransformer);
    }

    /**
     * @param Payslip $model
     * @return \League\Fractal\Resource\Item
     */
    public function includePayrun(Payslip $model)
    {
        $payrun = $model->payrun;

        return $this->item($payrun, new PayrunTransformer);
    }

    /**
     * @param Payslip $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeItems(Payslip $model)
    {
        $items = $model->items;

        return $this->collection($items, new PayslipItemTransformer);
    }

    /**
     * Transform the \Payslip entity
     * @param \Payslip $model
     *
     * @return array
     */
    public function transform(Payslip $model)
    {
        return [
            'id' => $model->id,
            'reference' => $model->reference,
            'pay_run_id' => $model->pay_run_id,
            'employee_id' => $model->employee_id,
            'wages' => $model->wages,
            'deductions' => $model->deductions,
            'tax' => $model->tax,
            'reimbursements' => $model->reimbursements,
            'net_pay' =>  $model->net_pay,
            'pdf_url' => $model->pdf_url,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

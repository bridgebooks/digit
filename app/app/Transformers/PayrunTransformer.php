<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Payrun;

/**
 * Class PayrunTransformer
 * @package namespace App\Transformers;
 */
class PayrunTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['payslips'];

    public function includePayslips(Payrun $model)
    {
        $payslips = $model->payslips;

        return $this->collection($payslips, new PayslipTransformer);
    }
    /**
     * Transform the \Payrun entity
     * @param \Payrun $model
     *
     * @return array
     */
    public function transform(Payrun $model)
    {
        return [
            'id' => $model->id,
            'user_id' => $model->user_id,
            'start_date' => $model->start_date->getTimestamp() * 1000,
            'end_date' => $model->end_date->getTimestamp() * 1000,
            'payment_date' => $model->payment_date->getTimestamp() * 1000,
            'employees' => count($model->payslips),
            'wages' => $model->wages,
            'deductions' => $model->deductions,
            'tax' => $model->tax,
            'reimbursements' => $model->reimbursements,
            'net_pay' =>  $model->net_pay,
            'status' => $model->status,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoicePayment;

/**
 * Class InvoicePaymentTransformer.
 *
 * @package namespace App\Transformers;
 */
class InvoicePaymentTransformer extends TransformerAbstract
{
    // protected $availableIncludes = [ 'invoice' ];

    protected $defaultIncludes = [ 'invoice' ];

    private function parseSourceType(string $type)
    {
        switch($type) {
            case 'App\Models\Invoice':
                return "Invoice";
                break;
            case 'App\Models\Payslip':
                return "Payslip";
                break;
        }
    }

    /**
     * @param InvoicePayment $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeInvoice(InvoicePayment $model)
    {
        $invoice = $model->invoice;
        switch($model->invoice_type) {
            case 'App\Models\Invoice':
                return $this->item($invoice, new InvoiceTransformer);
                break;
            case 'App\Models\Payslip':
                return $this->item($invoice, new PayslipTransformer);
                break;
        }
    }
    /**
     * Transform the InvoicePayment entity.
     *
     * @param \App\Models\InvoicePayment $model
     *
     * @return array
     */
    public function transform(InvoicePayment $model)
    {
        return [
            'id'  => $model->id,
            'invoice_id' => $model->invoice_id,
            'invoice_type' => $this->parseSourceType($model->invoice_type),
            'medium' => $model->medium,
            'transaction_ref' => $model->transaction_ref,
            'processor_ref' => $model->processor_ref,
            'processor_fee' => (float) $model->processor_fee,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'full_name' => $model->first_name. " ".$model->last_name,
            'email' => $model->email,
            'phone' => $model->phone,
            'amount' => (float) $model->amount,
            'status' => $model->status,
            'paid_at' => $model->paid_at ? $model->paid_at->getTimestamp() * 1000 : null,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

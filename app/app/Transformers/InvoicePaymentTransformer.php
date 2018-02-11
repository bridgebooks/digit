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

    /**
     * @param InvoicePayment $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeInvoice(InvoicePayment $model)
    {
        $invoice = $model->invoice;
        return $this->item($invoice, new InvoiceTransformer);
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
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

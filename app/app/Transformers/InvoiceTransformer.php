<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Invoice;
use App\Models\Contact;

/**
 * Class InvoiceTransformer
 * @package namespace App\Transformers;
 */
class InvoiceTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['contact', 'items'];

    public function includeContact(Invoice $invoice)
    {
        $contact = $invoice->contact;

        if ($contact) return $this->item($contact, new ContactTransformer);
    }

    public function includeItems(Invoice $invoice)
    {
        $items = $invoice->items;

        if ($items) return $this->collection($items, new InvoiceLineItemTransformer);
    }

    /**
     * Transform the \Invoice entity
     * @param \Invoice $model
     *
     * @return array
     */
    public function transform(Invoice $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'user_id' => $model->user_id,
            'contact_id' => $model->contact_id,
            'type' => $model->type,
            'line_amount_type' => $model->line_amount_type,
            'invoice_no' => $model->invoice_no,
            'reference' =>  $model->reference,
            'notes' => $model->notes,
            'status' => ucfirst($model->status),
            'sub_total' => $model->sub_total,
            'tax_total' => $model->tax_total,
            'total' => $model->total,
            'raised_at' => $model->raised_at->getTimestamp() * 1000,
            'due_at' => $model->due_at->getTimestamp() * 1000,
            'created_at' =>$model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Invoice;

/**
 * Class InvoiceTransformer
 * @package namespace App\Transformers;
 */
class InvoiceTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['contact', 'items', 'org', 'user'];

    //protected $defaultIncludes = ['contact'];

    public function includeOrg(Invoice $invoice)
    {
        $org = $invoice->org;

        return $this->item($org, new OrgTransformer);
    }

    public function includeContact(Invoice $invoice)
    {
        $contact = $invoice->contact;

        return $this->item($contact, new ContactTransformer);
    }

    public function includeUser(Invoice $invoice)
    {
        $user = $invoice->user;

        return $this->item($user, new UserTransformer);
    }

    public function includeItems(Invoice $invoice)
    {
        $items = $invoice->items;

        return $this->collection($items, new InvoiceLineItemTransformer);
    }

    private function getOverduePeriod ($dueDate) {
        $due_at = new Carbon($dueDate);
        $now = new Carbon('now');

        $difference = ($now->diffInDays($due_at) > 0 && !$due_at->isFuture()) ? $now->diffInDays($due_at) : 0;

        return $difference;
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
            'sub_total' => (float) $model->sub_total,
            'tax_total' => (float) $model->tax_total,
            'total' => (float) $model->total,
            'raised_at' => $model->raised_at->getTimestamp() * 1000,
            'due_at' => $model->due_at->getTimestamp() * 1000,
            'overdue' => in_array($model->status, ['paid', 'voided']) ? 0 : $this->getOverduePeriod($model->due_at),
            'pdf_url' => $model->pdf_url,
            'created_at' =>$model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}

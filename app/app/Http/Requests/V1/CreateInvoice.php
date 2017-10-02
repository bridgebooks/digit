<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInvoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'org_id' => 'required|exists:orgs,id',
            'contact_id' => 'required|exists:contacts,id',
            'type' => 'required|in:acc_rec,acc_pay',
            'due_at' => 'required|date',
            'raised_at' => 'date',
            'sub_total' => 'required|numeric',
            'tax_total' => 'required|numeric',
            'total' => 'required|numeric',
            'line_amount_type' => 'required|in:exclusive,inclusive,no_tax',
            'invoice_no' => Rule::unique('invoices')->where(function ($query) {
                $query->where('org_id', $this->request->get('org_id'));
            }),
            'reference' => Rule::unique('invoices')->where(function ($query) {
                $query->where('org_id', $this->request->get('org_id'));
            }),
            'items' => 'required|array'
        ];
    }
}

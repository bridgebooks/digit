<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoice extends FormRequest
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
            'contact_id' => 'exists:contacts,id',
            'due_at' => 'date',
            'raised_at' => 'date',
            'sub_total' => 'numeric',
            'tax_total' => 'numeric',
            'total' => 'numeric',
            'line_amount_type' => 'in:exclusive,inclusive,no_tax',
            'invoice_no' => Rule::unique('invoices')->where(function ($query) {
                $query->where('org_id', $this->request->get('org_id'));
            }),
            'reference' => Rule::unique('invoices')->where(function ($query) {
                $query->where('org_id', $this->request->get('org_id'));
            }),
            'items' => 'array'
        ];
    }
}

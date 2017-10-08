<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceSetting extends FormRequest
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
            'paper_size' => 'in:a4,a5,letter,a3',
            'org_bank_account_id' => 'exists:org_bank_accounts,id',
            'show_payment_advice' => 'boolean'
        ];
    }
}

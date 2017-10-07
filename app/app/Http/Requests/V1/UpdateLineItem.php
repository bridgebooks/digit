<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLineItem extends FormRequest
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
            'item_id' => 'exists:sale_items,id',
            'account_id' => 'exists:accounts,id',
            'tax_rate_id' => 'exists:tax_rates,id',
            'unit_price' => 'numeric|min:0',
            'discount_rate' => 'numeric|min:0',
            'amount' => 'numeric|min:0'
        ];
    }
}

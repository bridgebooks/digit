<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayItem extends FormRequest
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
            'account_id' => 'exists:accounts,id',
            'pay_item_type' => 'in:allowance,deductions,tax,',
            'mark_default' => 'boolean',
            'default_amount' => 'numeric'
        ];
    }
}

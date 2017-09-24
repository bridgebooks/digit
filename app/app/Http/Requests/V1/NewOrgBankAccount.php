<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class NewOrgBankAccount extends FormRequest
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
            'account_name' => 'required',
            'account_number' => 'required',
            'bank_id' => 'required|exists:banks,id'
        ];
    }
}

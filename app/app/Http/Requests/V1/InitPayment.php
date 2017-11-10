<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class InitPayment extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'card_no' => 'required|numeric|min:16',
            'cvv' => 'required|numeric|min:3',
            'expiry_year' => 'required',
            'expiry_month' => 'required'
        ];
    }
}

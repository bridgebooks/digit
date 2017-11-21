<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployee extends FormRequest
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
            'email' => 'email',
            'org_id' => 'exists:orgs,id',
            'bank_id' => 'exists:banks,id',
            'gender' => 'in:male,female',
            'date_of_birth' => 'date',
            'start_date' => 'date',
            'termination_date' => 'date',
            'status' => 'in:active,terminated'
        ];
    }
}

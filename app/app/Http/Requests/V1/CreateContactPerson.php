<?php

namespace App\Http\Requests\V1;

use App\Traits\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateContactPerson extends FormRequest
{
    use UserRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return
            $this->userHasRole('org_admin') ||
            $this->userHasRole('org_member') ||
            $this->userHasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_id' => 'required|exists:contacts,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:contact_people,email'
        ];
    }
}
